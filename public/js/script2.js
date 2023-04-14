// Load music page
$(document).ready(function() {
  function loadMusic(page) {
    $.ajax({
      url: "/music/loadMore",
      type: "POST",
      data: {page_no :page},
      success: function(data) {
        $("#musiclist").html(data);
      }
    });
  }

  loadMusic();

  // Pagination
  $(document).on("click", "#pagination a", function(e) {
    e.preventDefault();
    var page_id = $(this).attr("id");

    loadMusic(page_id);
  });
});

// Add to Favourite
$(document).ready(function() {
  function favourite() {
    $.ajax({
      url: "/music/favourites",
      type: "POST",
      success: function(data) {
        var favbutton;
        if(data == 1) {
          favbutton = '<a href="/music/favourites" id="fav-btn"><i class="fa fa-heart fa_custom fa-2x" style="color:red;"></a>';
        }
        else {
          favbutton = '<a href="/music/favourites" id="fav-btn"><i class="fa fa-heart fa_custom fa-2x" style="color:white;"></a>';
        }
        $("#fav").html(favbutton);
      }
    });
  }

  $(document).on("click", "#fav-btn", function(e) {
    e.preventDefault();
    favourite();
  })
});
