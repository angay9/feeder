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
using feeder.Models;

namespace feeder.view
{
    public partial class login_page : PhoneApplicationPage
    {
        private IsolatedStorageSettings appSettings = IsolatedStorageSettings.ApplicationSettings;
        
        public login_page()
        {
            InitializeComponent();

            Loaded += (s, e) =>
            {
                // TEST
                //NavigationService.Navigate(new Uri("/view/news_page.xaml", UriKind.Relative));

                if (appSettings.Contains("loggedIn") && (bool)appSettings["loggedIn"])
                    // Redirect, cause a user is already logged in
                    NavigationService.Navigate(new Uri("/view/news_page.xaml", UriKind.Relative));
            };
        }

        private void btnLogIn_Click(object sender, RoutedEventArgs e)
        {

            if (appSettings.Contains("user")) // User already registered an account
            {
                var user = (User)appSettings["user"];
                if (txbxLogin.Text == user.email && txbxPassword.Password == user.password)
                {
                    appSettings.Add("loggedIn", true);
                    
                    NavigationService.Navigate(new Uri("/view/news_page.xaml", UriKind.Relative));
                }
                else
                {
                    MessageBox.Show("Invalid credentials");
                }

            }
            else
            {
                MessageBox.Show("Invalid credentials");
            }

        }

        private void btnRegistration_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.Navigate(new Uri("/view/registration_page.xaml", UriKind.Relative));
        }

        private void PhoneApplicationPage_Loaded(object sender, RoutedEventArgs e)
        {
            
        }

    }
}