$(document).ready(function() {
    $('.like-btn').click(function(event) {
        event.preventDefault(); // Evita la recarga de la página
        var id_restaurante = $(this).data('id');
        var $likeCount = $(this).find('.like-count');
        var $dislikeCount = $(this).siblings('.dislike-btn').find('.dislike-count');
        $.post('../Controladores/like_dislike.php', { id_restaurante: id_restaurante, tipo: 'like' }, function(response) {
            if (response.status === 'success') {
                $likeCount.text(response.likes);
                $dislikeCount.text(response.dislikes);
            } else {
                alert(response.message);
            }
        }, 'json');
    });

    $('.dislike-btn').click(function(event) {
        event.preventDefault(); // Evita la recarga de la página
        var id_restaurante = $(this).data('id');
        var $likeCount = $(this).siblings('.like-btn').find('.like-count');
        var $dislikeCount = $(this).find('.dislike-count');
        $.post('../Controladores/like_dislike.php', { id_restaurante: id_restaurante, tipo: 'dislike' }, function(response) {
            if (response.status === 'success') {
                $likeCount.text(response.likes);
                $dislikeCount.text(response.dislikes);
            } else {
                alert(response.message);
            }
        }, 'json');
    });
});
