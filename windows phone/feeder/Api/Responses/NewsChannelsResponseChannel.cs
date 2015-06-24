using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Responses
{
    public class NewsChannelsResponseChannel
    {
        public int id { get; set; }
        public double price { get; set; }
        public string name { get; set; }
        public string feed { get; set; }
        public bool is_active { get; set; }
    }
}
