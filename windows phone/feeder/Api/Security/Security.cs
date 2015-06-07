using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Security
{
    public class Security
    {
        public static string Base64Encode(string text) 
        {
            return Convert.ToBase64String(System.Text.Encoding.UTF8.GetBytes(text));
        }

        public static string EncodeCredentials(string email, string password) 
        {
            return Base64Encode(email + ":" + password);
        }

        public static string GetAuthorizationHeader(string email, string password) 
        {
            return "Basic " + EncodeCredentials(email, password);
        }
    }
}
