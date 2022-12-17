function heart_vote(id_user,id_post,vote) {
    let score = document.querySelector('#voteHeart');
    var value = parseInt(score.innerHTML);
    value = isNaN(value) ? 0 : value;
    value++;
    score.innerHTML = value;
}