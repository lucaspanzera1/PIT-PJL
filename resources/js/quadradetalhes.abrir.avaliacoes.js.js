function toggleRatingForm() {
    const ratingForm = document.getElementById('rating-form');
    if (ratingForm.style.display === 'none') {
        ratingForm.style.display = 'block';
    } else {
        ratingForm.style.display = 'none';
    }
}