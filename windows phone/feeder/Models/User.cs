using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Models
{
    public class User
    {
        public string name { get; set; }
        public string email { get; set; }
        public string password { get; set; }
        public string guid { get; set; }

        public User() 
        {
            
        }

        public User(string name, string email, string password, string guid) 
        {
            this.name = name;
            this.email = email;
            this.password = password;
            this.guid = guid;
        }
    }
}
