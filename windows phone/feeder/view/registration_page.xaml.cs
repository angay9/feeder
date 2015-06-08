using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows;
using System.Windows.Navigation;
using Microsoft.Phone.Controls;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using feeder.Api;
using feeder.Api.Responses;
using System.IO.IsolatedStorage;
using feeder.Models;

namespace feeder
{
    public partial class registration_page : PhoneApplicationPage
    {
        private IsolatedStorageSettings appSettings = IsolatedStorageSettings.ApplicationSettings;

        public registration_page()
        {
            InitializeComponent();

            if (appSettings.Contains("loggedIn") && (bool)appSettings["loggedIn"])
                // Redirect, cause a user is already logged in
                NavigationService.Navigate(new Uri("/view/news_page.xaml", UriKind.Relative));
        }

        private void btnRegistration_Click(object sender, RoutedEventArgs e)
        {
            NavigationService.GoBack();
        }

        private async void Button_Click(object sender, RoutedEventArgs e)
        {
            await RegisterUser();
        }

        private async Task RegisterUser()
        {
            Guid guid = Guid.NewGuid();
            
            bool is_equals = txtbxpassword.Password== txtbxconfirmation.Password;
            Regex regex_tx = new Regex(@"^[a-zA-Z]{3,15}$");
            Regex email_tx = new Regex(@"^([\w\.\-]+)@([\w\-]+)((\.(\w){1,100})+)$");
            List<bool> is_match = new List<bool>();
            string errors = "";

            is_match.Add(true);
            

            if (regex_tx.IsMatch(txtbxpassword.Password))
            {
                is_match.Add(true);
                
            }
            else 
            {
                errors += "Password is not valid";
                is_match.Add(false);
            }
            if (regex_tx.IsMatch(txtbxconfirmation.Password))
                is_match.Add(true);
            else
            {
                is_match.Add(false);
                errors += "Password confirmation is not valid";
            }
                
            if (email_tx.IsMatch(txtbxemail.Text))
            {
                is_match.Add(true);
                
            }
            else
            {
                is_match.Add(false);
                errors += "E-mail is not valid";
            }
                
            if (txtbxpassword.Password == txtbxconfirmation.Password)
                is_match.Add(true);
            else
            {
                is_match.Add(false);
                errors += "Passwords do not equals";
            }
                
            if (is_match.All(x => x == true))
            {
                var result = await ApiHelper.RegisterUser(txtbxname.Text, txtbxpassword.Password, txtbxconfirmation.Password, txtbxemail.Text, guid.ToString());
                if (result is RegistrationResponseError)
                {
                    var response = ((RegistrationResponseError) result);
                    string errorMsg = "Error occured: \n";
                    if (response.messages.name != null && response.messages.name.Count() > 0)
                        errorMsg += String.Join("\n", response.messages.name.ToArray());
                    if (response.messages.email != null && response.messages.email.Count() > 0)
                        errorMsg += String.Join("\n", response.messages.email);
                    
                    if (response.messages.password!= null && response.messages.password.Count() > 0)
                        errorMsg += String.Join("\n", response.messages.password.ToArray());
                    if (response.messages.guid != null && response.messages.guid.Count() > 0)
                        errorMsg += String.Join("\n", response.messages.guid.ToArray());
                    
                    MessageBox.Show(errorMsg);
                }
                else
                {
                    appSettings.Add("user", new User(txtbxname.Text, txtbxemail.Text, txtbxpassword.Password, guid.ToString()));
                    MessageBox.Show("Your account has been registered. Please log in.");
                }
            }
            else
            {
                MessageBox.Show(errors);
            }
        }
    }
}