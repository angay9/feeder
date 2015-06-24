using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Responses
{
    public class NewsChannelsResponse
    {
        public string status { get; set; }
        public Dictionary<string, NewsChannelsResponseChannel[]> data { get; set; }
    }
}
