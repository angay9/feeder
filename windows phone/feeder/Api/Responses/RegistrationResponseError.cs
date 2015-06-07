using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace feeder.Api.Responses
{
    public class RegistrationResponseError : RegistrationResponse
    {
        public string status { get; set; }
        public RegistrationErrorMessages messages { get; set; }
    }
}
