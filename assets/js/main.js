// Mobile nav toggle
document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.main-nav');
    const toggle = document.querySelector('.nav-toggle');

    if (nav && toggle) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('open');
        });
    }

    // Sermon filters
    const seriesSelect = document.getElementById('filter-series');
    const speakerSelect = document.getElementById('filter-speaker');
    const sermonCards = document.querySelectorAll('.sermon');

    function applySermonFilters() {
        const series = seriesSelect ? seriesSelect.value : '';
        const speaker = speakerSelect ? speakerSelect.value : '';

        sermonCards.forEach(card => {
            const cardSeries = card.getAttribute('data-series') || '';
            const cardSpeaker = card.getAttribute('data-speaker') || '';

            const matchesSeries = !series || cardSeries === series;
            const matchesSpeaker = !speaker || cardSpeaker === speaker;

            card.style.display = matchesSeries && matchesSpeaker ? '' : 'none';
        });
    }

    if (seriesSelect || speakerSelect) {
        if (seriesSelect) seriesSelect.addEventListener('change', applySermonFilters);
        if (speakerSelect) speakerSelect.addEventListener('change', applySermonFilters);
    }

    // Simple calendar for events page (current month only, highlights today)
    const calendarEl = document.getElementById('events-calendar');
    if (calendarEl) {
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth();
        const today = now.getDate();

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const daysShort = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const header = document.createElement('div');
        header.className = 'calendar-header';
        header.innerHTML = `<span>${monthNames[month]} ${year}</span>`;

        const grid = document.createElement('div');
        grid.className = 'calendar-grid';

        daysShort.forEach(d => {
            const cell = document.createElement('div');
            cell.className = 'calendar-cell label';
            cell.textContent = d;
            grid.appendChild(cell);
        });

        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            grid.appendChild(empty);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const cell = document.createElement('div');
            cell.className = 'calendar-cell';
            if (day === today) {
                cell.classList.add('today');
            }
            cell.textContent = String(day);
            grid.appendChild(cell);
        }

        calendarEl.appendChild(header);
        calendarEl.appendChild(grid);
    }

    // Gallery lightbox
    const galleryLinks = document.querySelectorAll('[data-lightbox="gallery"]');

    function openLightbox(src, alt) {
        const backdrop = document.createElement('div');
        backdrop.className = 'lightbox-backdrop';

        const image = document.createElement('img');
        image.className = 'lightbox-image';
        image.src = src;
        image.alt = alt || '';

        const close = document.createElement('div');
        close.className = 'lightbox-close';
        close.innerHTML = '&times;';

        function closeLightbox() {
            document.body.removeChild(backdrop);
            document.body.removeChild(close);
            document.removeEventListener('keydown', onKeydown);
        }

        function onKeydown(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        }

        backdrop.addEventListener('click', closeLightbox);
        close.addEventListener('click', closeLightbox);
        document.addEventListener('keydown', onKeydown);

        backdrop.appendChild(image);
        document.body.appendChild(backdrop);
        document.body.appendChild(close);
    }

    if (galleryLinks.length > 0) {
        galleryLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const img = link.querySelector('img');
                const src = link.getAttribute('href');
                const alt = img ? img.alt : '';
                if (src) {
                    openLightbox(src, alt);
                }
            });
        });
    }

    // Give page demo message
    const giveBtn = document.getElementById('btn-give-demo');
    const giveMsg = document.getElementById('give-demo-message');
    if (giveBtn && giveMsg) {
        giveBtn.addEventListener('click', () => {
            giveMsg.classList.remove('hidden');
            giveMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }
});


