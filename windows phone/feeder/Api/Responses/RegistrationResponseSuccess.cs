using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Responses
{
    public class RegistrationResponseSuccess : RegistrationResponse
    {
        public string status { get; set; }
        public string[] data { get; set; }
    }
}
