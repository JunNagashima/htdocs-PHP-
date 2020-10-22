$(function() {
  $("#state_btn").on("click", function() {
    if($("#state") === "(カリキュラム終了)") {
      $("#state").text('(カリキュラム取組中)');
    });
  });
});
