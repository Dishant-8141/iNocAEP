<?php
  include 'navbar.php';
?>

<div class="container-fluid page-body-wrapper">
  <div class="row row-offcanvas row-offcanvas-right">
    
 
    <div id="page-wrapper">
 
      <div id="sidebarStyle">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav" id="menu-main">
            <li class="nav-item nav-category">
              <span class="nav-link">iNocAEP</span>
            </li>
            <li class="nav-item">
              <!-- <a class="nav-link" href="dashboard/dashboard.html"> -->
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-speedometer menu-icon"></i>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="charts/gaacArchitecture.html">
                <span class="menu-title">GAAC Architecture</span>
                <i class="icon-organization menu-icon"></i>
              </a>
            </li> -->
            <li>
              <a href="#" data-toggle="collapse" data-target="#sub1" id="dropdownLink" class="nav-link">
                <span class="menu-title">Analytics</span>
                <b class="caret pull-right"></b>
              </a>
              <ul class="sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="charts/productchart.html">
                    <span class="menu-title">Product Chart</span>
                    <i class="icon-chart menu-icon"></i>
                  </a>
                </li>
              
                <li class="nav-item">
                  <a class="nav-link" href="flowServices.php">
                    <span class="menu-title">Flow Analytics</span>
                    <i class="icon-pie-chart menu-icon"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="sourceAnalytics.php">
                    <span class="menu-title">Source Analytics</span>
                    <i class="icon-pie-chart menu-icon"></i>
                  </a>
                </li>
              </ul>
            </li>
            <!-- <li>
              <a href="#" data-toggle="collapse" data-target="#sub1" id="dropdownLink" class="nav-link">
                <span class="menu-title">Documentation</span>
                <b class="caret pull-right"></b>
              </a>
              <ul class="sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="html/faq.html">
                    <span class="menu-title">FAQ</span>
                    <i class="icon-question menu-icon"></i>
                  </a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" href="html/api.html">
                    <span class="menu-title">API</span>
                    <i class="icon-info menu-icon"></i>
                  </a>
                </li>
              </ul>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="html/settings.html">
                <span class="menu-title">Settings</span>
                <i class="icon-settings menu-icon"></i>
              </a>
            </li> -->
          </ul>
        </nav>
      </div>