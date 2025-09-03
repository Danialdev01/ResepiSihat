<!-- Footer -->
<footer class="bg-primary-700 text-white pb-8">
    <div class="mt-12 pt-8 border-white border-primary-800 text-center text-white">
        <p>© <?php echo date("Y")?> <span class="text-white hover:underline cursor-pointer"><a href="">ResepiSihat</a></span>. Hak Cipta Terpelihara.</p>
        <!-- <p>By <a href="https://danialirfan.dev">danial</a></p> -->
    </div>
</footer>

<script>
    // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidenav = document.querySelector('.sidenav');
        const overlay = document.querySelector('.overlay');
        
        mobileMenuButton.addEventListener('click', function() {
            sidenav.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', function() {
            sidenav.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Simulate progress bar animations
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
</script>


<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="<?php echo $location_index?>/src/assets/js/preline.js"></script>