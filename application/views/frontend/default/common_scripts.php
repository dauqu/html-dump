<script type="text/javascript">
function toggleRatingView(batch_id)
 {
  $('#course_rating_view_'+batch_id).toggle();
 }

function publishRating(batch_id) {
    var review = $('#review_of_a_course_'+batch_id).val();
    var starRating = 0;
    starRating = $('#star_rating_of_course_'+batch_id).val();

    if (starRating > 0) {
        $.ajax({
            type : 'POST',
            url  : '<?php echo site_url('home/rate_course'); ?>',
            data : {batch_id : batch_id, review : review, starRating : starRating},
            success : function(response) {
                location.reload();
            }
        });
    }else{

    }
}
</script>
