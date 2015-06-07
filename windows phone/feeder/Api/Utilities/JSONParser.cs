using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Utilities
{
    public static class JSONParser
    {
        public static T Parse<T>(string text) 
        {
            return JsonConvert.DeserializeObject<T>(text);
        }
    }
}
