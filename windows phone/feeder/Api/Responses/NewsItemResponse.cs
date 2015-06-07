using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Responses
{
    public class NewsItemResponse
    {
        public int id { get; set; }
        public string title { get; set; }
        public string description { get; set; }
        public string pub_date { get; set; }
        public string link { get; set; }
        public int service_id { get; set; }
    }
}
