document.getElementById("openFormBtn").addEventListener("click", function() {
    document.getElementById("feedback-user-form").classList.add("show");
});
document.getElementById("closeFormBtn").addEventListener("click", function() {
    document.getElementById("feedback-user-form").classList.remove("show");
});
document.addEventListener("DOMContentLoaded", function() {
    var textarea = document.querySelector('textarea');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
document.getElementById('loadMoreButton').addEventListener('click', function() {
    document.getElementById('hiddenFeedbacks').style.display = 'block';
    this.style.display = 'none';
});
