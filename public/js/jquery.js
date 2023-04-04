// Load music page
$(document).ready(function() {
  function loadTable(page) {
    $.ajax({
      url: "/music/loadMore",
      type: "POST",
      data: {page_no :page},
      success: function(data) {
        $("#musiclist").html(data);
      }
    });
  }

  loadTable();

  // Pagination
  $(document).on("click", "#pagination a", function(e) {
    e.preventDefault();
    var page_id = $(this).attr("id");

    loadTable(page_id);
  });
});

// Add to Favourite
$(document).ready(function() {
  function favourite() {
    $.ajax({
      url: "/music/favourites",
      type: "POST",
      success: function(data) {
        $("#fav").html(data);
      }
    });
  }

  $(document).on("click", "#fav-btn", function(e) {
    e.preventDefault();
    favourite();
  })
});
