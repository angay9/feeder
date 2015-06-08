using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Navigation;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;
using feeder.Api.Security;
using feeder.Api;
using feeder.Api.Responses;
using feeder.Models;
using System.IO.IsolatedStorage;

namespace feeder.view
{
    public partial class NewsChannelPage : PhoneApplicationPage
    {
        private string newsChannel { get; set; }

        private Dictionary<string, string> newsNames;

        private IsolatedStorageSettings appSettings = IsolatedStorageSettings.ApplicationSettings;

        private List<NewsChannelsResponseChannel> channels = new List<NewsChannelsResponseChannel>();

        public NewsChannelPage()
        {
            newsNames = new Dictionary<string, string>()
            {
                {"bbc", "BBC"},
                {"yahoo", "Yahoo"},
                {"nyt", "New York Times"},
                {"espn", "ESPN"}
            };

            InitializeComponent();

            Loaded += (s, e) =>
            {
                newsChannel = NavigationContext.QueryString["channel"];
                txtPageName.Text = newsNames[newsChannel];
                Init();
            };
        }

        public async void Init() 
        {
            //var authHeader = Security.GetAuthorizationHeader("tf@mail.com", "password");
            //var guid = "668a3e10-6722-4797-bc32-1a0bc4ff4444";

            var user = (User)appSettings["user"];
            var authHeader = Security.GetAuthorizationHeader(user.email, user.password);
            var guid = user.guid;

            var response = await ApiHelper.GetNewsChannels(authHeader, guid, newsChannel);
            channels = response.data.First().Value.ToList();
            listBoxNews.Items.Clear();
            channels.ForEach(c => listBoxNews.Items.Add(c));

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            var tag = ((Button) sender).Tag;

            var item = channels.Where(c => c.feed == (string) tag).FirstOrDefault();

            if (item != null) 
            {
                NavigationService.Navigate(new Uri("/view/News.xaml?newsType=" + item.name + "&feedType=" + item.feed, UriKind.Relative));
            }
        }

    }


}