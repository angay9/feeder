﻿#pragma checksum "E:\xampp\htdocs\feeder\windows phone\feeder\view\news_page.xaml" "{406ea660-64cf-4c82-b6f0-42d48172a799}" "70B5B62BC1BC2A2A4A667E80DBCBA273"
//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:4.0.30319.18408
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


namespace feeder.view {
    
    
    public partial class news_page : Microsoft.Phone.Controls.PhoneApplicationPage {
        
        internal System.Windows.Controls.Grid LayoutRoot;
        
        internal Microsoft.Phone.Controls.Pivot pivot_news;
        
        internal System.Windows.Controls.Button BBCBtn;
        
        internal System.Windows.Controls.Button NYTBtn;
        
        internal System.Windows.Controls.Button ESPNBtn;
        
        internal System.Windows.Controls.Button YahooBtn;
        
        internal System.Windows.Controls.Button sh_all_service;
        
        internal System.Windows.Controls.Button sh_user_service;
        
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
            System.Windows.Application.LoadComponent(this, new System.Uri("/feeder;component/view/news_page.xaml", System.UriKind.Relative));
            this.LayoutRoot = ((System.Windows.Controls.Grid)(this.FindName("LayoutRoot")));
            this.pivot_news = ((Microsoft.Phone.Controls.Pivot)(this.FindName("pivot_news")));
            this.BBCBtn = ((System.Windows.Controls.Button)(this.FindName("BBCBtn")));
            this.NYTBtn = ((System.Windows.Controls.Button)(this.FindName("NYTBtn")));
            this.ESPNBtn = ((System.Windows.Controls.Button)(this.FindName("ESPNBtn")));
            this.YahooBtn = ((System.Windows.Controls.Button)(this.FindName("YahooBtn")));
            this.sh_all_service = ((System.Windows.Controls.Button)(this.FindName("sh_all_service")));
            this.sh_user_service = ((System.Windows.Controls.Button)(this.FindName("sh_user_service")));
        }
    }
}

