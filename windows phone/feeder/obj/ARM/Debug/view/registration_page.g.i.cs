﻿#pragma checksum "C:\xampp\htdocs\feeder\windows phone\feeder\feeder\view\registration_page.xaml" "{406ea660-64cf-4c82-b6f0-42d48172a799}" "011E3AF9D6CABAF3F4004B56C23345A4"
//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:4.0.30319.0
//
//     Changes to this file may cause incorrect behavior and will be lost if
//     the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

using Microsoft.Phone.Controls;
using System;
using System.Windows;
using System.Windows.Automation;
using System.Windows.Automation.Peers;
using System.Windows.Automation.Provider;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Interop;
using System.Windows.Markup;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Imaging;
using System.Windows.Resources;
using System.Windows.Shapes;
using System.Windows.Threading;


namespace feeder {
    
    
    public partial class registration_page : Microsoft.Phone.Controls.PhoneApplicationPage {
        
        internal System.Windows.Controls.Grid LayoutRoot;
        
        internal System.Windows.Controls.Grid grdTop;
        
        internal System.Windows.Controls.Image imgNews;
        
        internal Microsoft.Phone.Controls.PhoneTextBox txbxname;
        
        internal Microsoft.Phone.Controls.PhoneTextBox txbxemail;
        
        internal Microsoft.Phone.Controls.PhoneTextBox txbxpassord;
        
        internal Microsoft.Phone.Controls.PhoneTextBox txbxconfirmation;
        
        internal System.Windows.Controls.Button btnBack;
        
        private bool _contentLoaded;
        
        /// <summary>
        /// InitializeComponent
        /// </summary>
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        public void InitializeComponent() {
            if (_contentLoaded) {
                return;
            }
            _contentLoaded = true;
            System.Windows.Application.LoadComponent(this, new System.Uri("/feeder;component/view/registration_page.xaml", System.UriKind.Relative));
            this.LayoutRoot = ((System.Windows.Controls.Grid)(this.FindName("LayoutRoot")));
            this.grdTop = ((System.Windows.Controls.Grid)(this.FindName("grdTop")));
            this.imgNews = ((System.Windows.Controls.Image)(this.FindName("imgNews")));
            this.txbxname = ((Microsoft.Phone.Controls.PhoneTextBox)(this.FindName("txbxname")));
            this.txbxemail = ((Microsoft.Phone.Controls.PhoneTextBox)(this.FindName("txbxemail")));
            this.txbxpassord = ((Microsoft.Phone.Controls.PhoneTextBox)(this.FindName("txbxpassord")));
            this.txbxconfirmation = ((Microsoft.Phone.Controls.PhoneTextBox)(this.FindName("txbxconfirmation")));
            this.btnBack = ((System.Windows.Controls.Button)(this.FindName("btnBack")));
        }
    }
}

