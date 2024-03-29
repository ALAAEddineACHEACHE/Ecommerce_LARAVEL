<script>
    var mainImage = document.querySelector('#image-product');
    var thumbnails = document.querySelectorAll('.img-thumbnail');
    thumbnails.forEach((element) => element.addEventListener('click', changeImage));

    function changeImage(e) {
        mainImage.src = this.src;
    }
</script>
