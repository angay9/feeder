using feeder.Api.Responses;
using feeder.Api.Utilities;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api
{
    public class ApiHelper
    {
        private const string url = "http://169.254.80.80:8080/api/";

        public static async Task<HttpResponseMessage> Post(string path, Dictionary<string, string> data, Dictionary<string, string> headers = null)
        {
            Uri myUri = new Uri(url + path);

            HttpClient http = new HttpClient();

            MultipartFormDataContent postData = new MultipartFormDataContent("Upload----" + DateTime.Now.ToString(CultureInfo.InvariantCulture));

            foreach (var item in data)
            {
                postData.Add(new StringContent(item.Value), item.Key);
            }

            if (headers != null)
            {
                foreach (var header in headers)
                {
                    http.DefaultRequestHeaders.Add(header.Key, header.Value);
                }
            }
            

            var response = await http.PostAsync(myUri, postData).ConfigureAwait(continueOnCapturedContext: false);
            return response;
        }

        public static async Task<HttpResponseMessage> Get(string path, Dictionary<string, string> headers = null)
        {
            //Create Client 
            var client = new HttpClient();

            var uri = new Uri(url + path);
            if (headers != null)
            {
                foreach (var header in headers)
                {
                    client.DefaultRequestHeaders.Add(header.Key, header.Value);
                }
            }
            
            var response = await client.GetAsync(uri);


            return response;
        }

        public static async Task<RegistrationResponse> RegisterUser(string name, string password, string confirmation_password, string email, string guid)
        {
            var response = await Post("users", new Dictionary<string, string>() { 
                {"name", name },
                {"password", password },
                {"password_confirmation", confirmation_password },
                {"email", email },
                {"guid", guid },
            });

            var json = await response.Content.ReadAsStringAsync();
            try
            {
                return JSONParser.Parse<RegistrationResponseSuccess>(json);
            }
            catch (WebException ex)
            {
                return JSONParser.Parse<RegistrationResponseError>(json);

            }
            
        }

        public static async Task<NewsChannelsResponse> GetNewsChannels(string authHeader, string guid, string channel = "") 
        {
            var headers = new Dictionary<string, string>() 
            {
                {"Authorization", authHeader},
                {"guid", guid}
            };

            var response = await Get("users/services/" + channel, headers);
            try
            {
                response.EnsureSuccessStatusCode();
                var body = await response.Content.ReadAsStringAsync();
                return JSONParser.Parse<NewsChannelsResponse>(body);
            }
            catch (Exception ex)
            {
                return null;
            }
        }

        public static async Task<Boolean> PayForService(string authHeader, string guid, int serviceId) 
        {
            var response = await Post("payments", 
                new Dictionary<string,string>() { {"service_id", serviceId.ToString() } },
                new Dictionary<string, string>() 
                {
                    {"Authorization", authHeader},
                    {"guid", guid}
                }
            );

            return response.IsSuccessStatusCode;
        }

        public static async Task<List<NewsItemResponse>> GetNews(string authHeader, string guid, string newsType, string feedsType, int offset = 0, int limit = 5) 
        {
            var response = await Get(String.Format("feeds/{0}/{1}/{2}/{3}", newsType, feedsType, offset, limit),
                new Dictionary<string, string>() 
                {
                    {"Authorization", authHeader},
                    {"guid", guid}
                }
            );

            if (response.IsSuccessStatusCode)
            {
                var body = await response.Content.ReadAsStringAsync();

                return JSONParser.Parse<List<NewsItemResponse>>(body);

            }

            return null;
        }
    }
}
