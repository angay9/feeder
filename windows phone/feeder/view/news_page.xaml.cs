using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Navigation;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;
using Windows.Storage;
using System.IO.IsolatedStorage;
using System.Threading.Tasks;
using feeder.Models;
using feeder.Api.Security;
using feeder.Api;
using feeder.Api.Responses;

namespace feeder.view
{
    public partial class news_page : PhoneApplicationPage
    {

        IsolatedStorageSettings settings = IsolatedStorageSettings.ApplicationSettings;

        private List<NewsChannelsResponseChannel> channels = new List<NewsChannelsResponseChannel>();

        public news_page()
        {
            InitializeComponent();
        }

        private void BBCBtn_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.Navigate(new Uri("/view/NewsChannelPage.xaml?channel=bbc", UriKind.Relative));
        }

        private void NYTBtn_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.Navigate(new Uri("/view/NewsChannelPage.xaml?channel=nyt", UriKind.Relative));

        }

        private void ESPNBtn_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.Navigate(new Uri("/view/NewsChannelPage.xaml?channel=espn", UriKind.Relative));

        }

        private void YahooBtn_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.Navigate(new Uri("/view/NewsChannelPage.xaml?channel=yahoo", UriKind.Relative));
        }
        
    }
}