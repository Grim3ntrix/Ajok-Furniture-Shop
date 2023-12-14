$(document).ready(function() {
    // Get current page URL
    var url = window.location.href;
  
    // Remove trailing slash and get last part of URL
    var urlParts = url.replace(/\/$/, '').split('/');
    var currentPage = urlParts[urlParts.length - 1];
  
    // Loop through nav links
    $(".navbar-nav li a").each(function() {
      // Get link URL
      var link = $(this).attr("href");
  
      // Check if link URL matches current page URL
      if (link == currentPage) {
        // Add active class to link and its parent (list item)
        $(this).addClass("active");
        $(this).parent().addClass("active");
      }
    });
  });
  