    <footer>
        
        <p style="text-align:center;">© 2025 دار الشباب - جميع الحقوق محفوظة</p>
    </footer>
<!-- Bouton retour en haut -->
<button id="scrollTopBtn" title="Retour en haut"><i class="fas fa-arrow-up"></i></button>

<script>
    // Bouton retour en haut
    const scrollBtn = document.getElementById('scrollTopBtn');
    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollBtn.style.display = "flex";
        } else {
            scrollBtn.style.display = "none";
        }
    };
    scrollBtn.addEventListener('click', () => {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
</script>

</body>
</html>
