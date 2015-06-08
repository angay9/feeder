using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Navigation;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;
using feeder.Api;
using feeder.Api.Responses;
using feeder.Api.Security;
using Microsoft.Phone.Tasks;
using System.Threading.Tasks;
using feeder.Models;
using System.IO.IsolatedStorage;

namespace feeder.view
{
    public partial class News : PhoneApplicationPage
    {
        private IsolatedStorageSettings appSettings = IsolatedStorageSettings.ApplicationSettings;
        private List<NewsChannelsResponseChannel> channels = new List<NewsChannelsResponseChannel>();
        private List<NewsItemResponse> news = new List<NewsItemResponse>();
        private NewsChannelsResponseChannel currentChannel;
        private string newsType { get; set; }
        private string feedType { get; set; }
        private int offset = 0;
        private int limit = 5;
        private string authHeader;
        private string guid;
        private bool isLastPage = false;


        public News()
        {

            InitializeComponent();
            Loaded += (s, e) =>
            {
                newsType = NavigationContext.QueryString["newsType"];
                feedType = NavigationContext.QueryString["feedType"];

                Init();
            };
        }

        public async void Init() 
        {
            //authHeader = Security.GetAuthorizationHeader("tf@mail.com", "password");
            //guid = "668a3e10-6722-4797-bc32-1a0bc4ff4444";

            var user = (User)appSettings["user"];
            authHeader = Security.GetAuthorizationHeader(user.email, user.password);
            guid = user.guid;

            var response = await ApiHelper.GetNewsChannels(authHeader, guid);
            channels = response.data.First().Value.ToList();
            currentChannel = channels.Where(c => c.name == newsType && c.feed == feedType).FirstOrDefault();


            if (!ValidateAccess())
            {
                // This channel is not yet purchased.
                payBtn.Visibility = payText.Visibility = System.Windows.Visibility.Visible;
            }
            else
            {
                btnPrev.Visibility = btnNext.Visibility = System.Windows.Visibility.Visible;
                await ShowNews();
                if (news == null || news.Count == 0)
                    MessageBox.Show("No news items available.");
            }
        }
        
        public async Task ShowNews() 
        {
            // Show news
            var result = await ApiHelper.GetNews(authHeader, guid, currentChannel.name, currentChannel.feed, offset, limit);

            if (result != null && result.Count > 0)
            {
                listBoxNews.Visibility = System.Windows.Visibility.Visible;
                news = result;
                listBoxNews.Items.Clear();
                news.ForEach(n => listBoxNews.Items.Add(n));
            }
            else
            {
                isLastPage = true;
            }
        }

        public bool ValidateAccess()
        {
            return channels.Any(c => c.name == newsType && c.feed == feedType && c.is_active);
        }

        private async void payBtn_Click(object sender, RoutedEventArgs e)
        {
            
            if (currentChannel != null) 
            {
                
                if (await ApiHelper.PayForService(authHeader, guid, currentChannel.id))
                {
                    MessageBox.Show("Email with payment info was sent.");
                }
                else 
                {
                    MessageBox.Show("Server error. Please try again later.");
                }
            }
        }

        private void showNewsBtn_Click(object sender, RoutedEventArgs e)
        {
            var tag = (sender as Button).Tag.ToString();
            WebBrowserTask webBrowserTask = new WebBrowserTask();
            webBrowserTask.Uri = new Uri(tag);
            webBrowserTask.Show();
        }

        private async void paginationBtnClick(object sender, RoutedEventArgs e)
        {
            var tag = (sender as Button).Tag.ToString();
            
            if (tag == "prev") 
            {
                offset = offset - limit;

                if (offset < 0)
                {
                    offset = 0;
                }
                else
                {
                    await ShowNews();
                }
            }
            else if (tag == "next")
            {
                offset = offset + limit;
                await ShowNews();
                if (isLastPage)
                {
                    offset = offset - limit;
                    MessageBox.Show("No news items available.");
                }
            }
        }

    }
}