    // public/js/navbar.js
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('navbarToggle1');
        const menu   = document.getElementById('navbarMenu1');

        if (!toggle || !menu) {
            console.warn('navbarToggle1 atau navbarMenu1 tidak ditemukan');
            return;
        }

        toggle.addEventListener('click', () => {
            menu.classList.toggle('show');
        });
    });


    // Fungsi cek apakah elemen sudah terlihat di viewport
    function checkScroll() {
        const elements = document.querySelectorAll('.animate__fade-in');
        elements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top + rect.height / 2 < window.innerHeight) {
                el.classList.add('animate__active');
            }
        });
    }

    // Jalankan saat halaman pertama kali dimuat
    window.addEventListener('load', checkScroll);

    // Jalankan lagi saat user scroll
    window.addEventListener('scroll', checkScroll);


    //-------- Block---------------------------------//
    const blocks = document.querySelectorAll('.block');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('visible');
        });
    }, { threshold: 0.2 });

    blocks.forEach(el => io.observe(el));

    //------- batas blovk-----------------------------//


    //------- btn profil-----------------------------------//
        document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('btnProfil');
        const target = document.getElementById('profil');

        btn?.addEventListener('click', () => {
            target?.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // animasi block
    document.querySelectorAll('.block').forEach(el => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        });
        observer.observe(el);
    });

    // animasi muncul dan menghilang
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Scroll down - element enters viewport
                    entry.target.classList.add('visible');
                    entry.target.classList.remove('hidden');
                } else {
                    // Scroll up - element exits viewport
                    if (window.scrollY < entry.boundingClientRect.top) {
                        entry.target.classList.remove('visible');
                        entry.target.classList.add('hidden');
                    }
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.block-element').forEach(el => {
            observer.observe(el);
        });
    });
