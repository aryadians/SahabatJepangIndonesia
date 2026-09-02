/**
 * LPK SAHABAT JEPANG INDONESIA - CORE JAVASCRIPT
 * Modern 3D Canvas, Scroll Observer, Pop-up Modals, Salary Simulator, & Lazy Loading
 */

document.addEventListener('DOMContentLoaded', () => {
    init3DHeroCanvas();
    initScrollAnimations();
    initStatsCounter();
    initNavbarScroll();
    initSalaryCalculator();
    initModals();
    initLazyLoading();
    initConsultationForm();
    initScrollToTop();
    initFaqAccordion();
});

/* ==========================================================================
   1. 3D HERO CANVAS - SAKURA PETALS & PARTICLES
   ========================================================================== */
function init3DHeroCanvas() {
    const canvas = document.getElementById('hero3dCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = (canvas.width = canvas.parentElement.offsetWidth);
    let height = (canvas.height = canvas.parentElement.offsetHeight);

    let mouse = { x: width / 2, y: height / 2, targetX: width / 2, targetY: height / 2 };
    let petals = [];
    let particles = [];
    const petalCount = window.innerWidth < 768 ? 25 : 55;
    const particleCount = window.innerWidth < 768 ? 20 : 40;

    window.addEventListener('resize', () => {
        if (!canvas.parentElement) return;
        width = canvas.width = canvas.parentElement.offsetWidth;
        height = canvas.height = canvas.parentElement.offsetHeight;
    });

    window.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.targetX = e.clientX - rect.left;
        mouse.targetY = e.clientY - rect.top;
    });

    // Sakura Petal Class
    class SakuraPetal {
        constructor() {
            this.reset(true);
        }

        reset(initial = false) {
            this.x = Math.random() * width;
            this.y = initial ? Math.random() * height : -20;
            this.size = Math.random() * 12 + 8;
            this.speedX = Math.random() * 1.5 - 0.5;
            this.speedY = Math.random() * 1.2 + 0.8;
            this.rotation = Math.random() * 360;
            this.rotSpeed = (Math.random() - 0.5) * 2;
            this.oscillation = Math.random() * Math.PI * 2;
            this.oscSpeed = Math.random() * 0.03 + 0.01;
            this.opacity = Math.random() * 0.5 + 0.4;
            // 3D Tilt effect
            this.flip = Math.random() * Math.PI;
            this.flipSpeed = Math.random() * 0.03 + 0.01;
            this.color = Math.random() > 0.3 ? '#FFAAB8' : '#FFD1DC';
        }

        update() {
            this.oscillation += this.oscSpeed;
            this.flip += this.flipSpeed;
            this.rotation += this.rotSpeed;

            // Wind influence from mouse
            const dx = (mouse.x - this.x) * 0.0005;
            this.x += this.speedX + Math.sin(this.oscillation) * 1.2 + dx;
            this.y += this.speedY;

            if (this.y > height + 20 || this.x < -30 || this.x > width + 30) {
                this.reset();
            }
        }

        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate((this.rotation * Math.PI) / 180);
            ctx.scale(Math.sin(this.flip), 1);

            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.bezierCurveTo(this.size / 2, -this.size / 2, this.size, -this.size / 4, this.size, this.size / 2);
            ctx.bezierCurveTo(this.size, this.size, this.size / 2, this.size * 1.2, 0, this.size * 1.4);
            ctx.bezierCurveTo(-this.size / 2, this.size * 1.2, -this.size, this.size, -this.size, this.size / 2);
            ctx.bezierCurveTo(-this.size, -this.size / 4, -this.size / 2, -this.size / 2, 0, 0);
            ctx.closePath();

            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.opacity;
            ctx.shadowColor = 'rgba(255, 182, 193, 0.4)';
            ctx.shadowBlur = 6;
            ctx.fill();

            ctx.restore();
        }
    }

    // Glow Particles Class (Tokyo - Jakarta Network)
    class GlowParticle {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.radius = Math.random() * 2.5 + 1;
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;
            this.alpha = Math.random() * 0.4 + 0.2;
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;
            if (this.x < 0 || this.x > width || this.y < 0 || this.y > height) {
                this.reset();
            }
        }

        draw() {
            ctx.save();
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#DC2626';
            ctx.globalAlpha = this.alpha;
            ctx.shadowColor = '#DC2626';
            ctx.shadowBlur = 8;
            ctx.fill();
            ctx.restore();
        }
    }

    // Populate Arrays
    for (let i = 0; i < petalCount; i++) {
        petals.push(new SakuraPetal());
    }
    for (let i = 0; i < particleCount; i++) {
        particles.push(new GlowParticle());
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Smooth mouse lag
        mouse.x += (mouse.targetX - mouse.x) * 0.05;
        mouse.y += (mouse.targetY - mouse.y) * 0.05;

        // Draw connections between nearby glow particles
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dist = Math.hypot(particles[i].x - particles[j].x, particles[i].y - particles[j].y);
                if (dist < 110) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = '#DC2626';
                    ctx.globalAlpha = (1 - dist / 110) * 0.12;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }

        particles.forEach((p) => {
            p.update();
            p.draw();
        });

        petals.forEach((p) => {
            p.update();
            p.draw();
        });

        requestAnimationFrame(animate);
    }

    animate();
}

/* ==========================================================================
   2. SCROLL REVEAL ANIMATIONS (INTERSECTION OBSERVER)
   ========================================================================== */
function initScrollAnimations() {
    const targets = document.querySelectorAll(
        '.reveal-on-scroll, .reveal-fade, .reveal-scale, .reveal-slide-left, .reveal-slide-right'
    );

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -60px 0px',
        threshold: 0.15,
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    targets.forEach((el) => observer.observe(el));
}

/* ==========================================================================
   3. STATS NUMBER COUNTER
   ========================================================================== */
function initStatsCounter() {
    const counterElements = document.querySelectorAll('[data-counter]');
    if (!counterElements.length) return;

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const targetVal = parseInt(el.getAttribute('data-counter'), 10);
                    const suffix = el.getAttribute('data-suffix') || '';
                    let current = 0;
                    const duration = 1800; // ms
                    const stepTime = 20;
                    const increment = targetVal / (duration / stepTime);

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= targetVal) {
                            el.textContent = targetVal.toLocaleString('id-ID') + suffix;
                            clearInterval(timer);
                        } else {
                            el.textContent = Math.floor(current).toLocaleString('id-ID') + suffix;
                        }
                    }, stepTime);

                    obs.unobserve(el);
                }
            });
        },
        { threshold: 0.5 }
    );

    counterElements.forEach((el) => observer.observe(el));
}

/* ==========================================================================
   4. STICKY NAVBAR SCROLL BEHAVIOR & MOBILE DRAWER
   ========================================================================== */
function initNavbarScroll() {
    const navbar = document.getElementById('mainNavbar');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    window.addEventListener('scroll', () => {
        if (!navbar) return;
        if (window.scrollY > 40) {
            navbar.classList.add('shadow-md', 'bg-white/95');
            navbar.classList.remove('bg-white/80');
        } else {
            navbar.classList.remove('shadow-md', 'bg-white/95');
            navbar.classList.add('bg-white/80');
        }
    });

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu on clicking any link
        const navLinks = mobileMenu.querySelectorAll('a');
        navLinks.forEach((link) => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }
}

/* ==========================================================================
   5. INTERACTIVE SALARY & SAVINGS SIMULATOR
   ========================================================================== */
function initSalaryCalculator() {
    const sectorSelect = document.getElementById('calcSector');
    const prefectureSelect = document.getElementById('calcPrefecture');
    const overtimeRange = document.getElementById('calcOvertime');
    const overtimeDisplay = document.getElementById('overtimeHoursDisplay');

    const grossSalaryYenEl = document.getElementById('calcGrossYen');
    const grossSalaryIdrEl = document.getElementById('calcGrossIdr');
    const deductionsYenEl = document.getElementById('calcDeductionsYen');
    const livingCostYenEl = document.getElementById('calcLivingCostYen');
    const netSavingsYenEl = document.getElementById('calcNetSavingsYen');
    const netSavingsIdrEl = document.getElementById('calcNetSavingsIdr');

    if (!sectorSelect || !grossSalaryYenEl) return;

    // Exchange rate approx (1 JPY = Rp 106.5)
    const JPY_TO_IDR = 106.5;

    function calculate() {
        const baseSectorSalary = parseInt(sectorSelect.value, 10) || 200000;
        const prefMultiplier = parseFloat(prefectureSelect ? prefectureSelect.value : 1.0) || 1.0;
        const overtimeHours = parseInt(overtimeRange ? overtimeRange.value : 15, 10) || 0;

        if (overtimeDisplay) {
            overtimeDisplay.textContent = `${overtimeHours} Jam / bln`;
        }

        // Calculations
        const adjustedBase = baseSectorSalary * prefMultiplier;
        const hourlyRate = (adjustedBase / 160) * 1.25; // 1.25x for overtime
        const overtimePay = overtimeHours * hourlyRate;
        const grossSalary = Math.round(adjustedBase + overtimePay);

        // Deductions (Taxes, Health Insurance, Shakai Hoken, Pension Nenkin ~ 18%)
        const deductions = Math.round(grossSalary * 0.18);

        // Living Cost (Apartment/Dorm + Food + Utilities in Japan ~ ¥45,000 - ¥60,000 depending on region)
        const livingCost = Math.round(48000 * prefMultiplier);

        // Net Savings
        const netSavings = Math.max(0, grossSalary - deductions - livingCost);

        // Format and display
        grossSalaryYenEl.textContent = `¥ ${grossSalary.toLocaleString('id-ID')}`;
        grossSalaryIdrEl.textContent = `≈ Rp ${Math.round((grossSalary * JPY_TO_IDR) / 1000).toLocaleString('id-ID')}.000`;

        if (deductionsYenEl) deductionsYenEl.textContent = `- ¥ ${deductions.toLocaleString('id-ID')}`;
        if (livingCostYenEl) livingCostYenEl.textContent = `- ¥ ${livingCost.toLocaleString('id-ID')}`;

        netSavingsYenEl.textContent = `¥ ${netSavings.toLocaleString('id-ID')}`;
        netSavingsIdrEl.textContent = `≈ Rp ${Math.round((netSavings * JPY_TO_IDR) / 1000).toLocaleString('id-ID')}.000 / bln`;
    }

    if (sectorSelect) sectorSelect.addEventListener('change', calculate);
    if (prefectureSelect) prefectureSelect.addEventListener('change', calculate);
    if (overtimeRange) overtimeRange.addEventListener('input', calculate);

    // Initial calculation
    calculate();
}

/* ==========================================================================
   6. MODAL & POP-UP CONTROLLERS
   ========================================================================== */
window.openModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
};

window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = '';
};

function initModals() {
    // Close modal on click backdrop
    document.querySelectorAll('.custom-modal').forEach((modal) => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal || e.target.classList.contains('modal-backdrop-blur')) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.custom-modal.active').forEach((modal) => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });

    // Open Program detail modal helper
    window.showProgramDetail = function (programJsonStr) {
        try {
            const data = typeof programJsonStr === 'string' ? JSON.parse(programJsonStr) : programJsonStr;
            const titleEl = document.getElementById('progModalTitle');
            const subEl = document.getElementById('progModalSubtitle');
            const japEl = document.getElementById('progModalJapTitle');
            const descEl = document.getElementById('progModalDesc');
            const salaryYenEl = document.getElementById('progModalSalaryYen');
            const salaryIdrEl = document.getElementById('progModalSalaryIdr');
            const durEl = document.getElementById('progModalDuration');
            const sectorsList = document.getElementById('progModalSectors');
            const reqsList = document.getElementById('progModalReqs');
            const benefitsList = document.getElementById('progModalBenefits');
            const applySelect = document.getElementById('consultProgramSelect');

            if (titleEl) titleEl.textContent = data.title;
            if (subEl) subEl.textContent = data.subtitle;
            if (japEl) japEl.textContent = data.japanese_title || '';
            if (descEl) descEl.textContent = data.description;
            if (salaryYenEl) salaryYenEl.textContent = data.salary_yen;
            if (salaryIdrEl) salaryIdrEl.textContent = data.salary_idr;
            if (durEl) durEl.textContent = data.duration;

            if (sectorsList && data.sectors) {
                sectorsList.innerHTML = data.sectors.map((s) => `<li class="flex items-start gap-2"><span class="text-red-600 font-bold">✓</span><span>${s}</span></li>`).join('');
            }
            if (reqsList && data.requirements) {
                reqsList.innerHTML = data.requirements.map((r) => `<li class="flex items-start gap-2"><span class="text-red-600 font-bold">•</span><span>${r}</span></li>`).join('');
            }
            if (benefitsList && data.benefits) {
                benefitsList.innerHTML = data.benefits.map((b) => `<li class="flex items-start gap-2"><span class="text-emerald-600 font-bold">★</span><span>${b}</span></li>`).join('');
            }

            // Set preset program on registration modal button
            const registerFromProgBtn = document.getElementById('registerFromProgModalBtn');
            if (registerFromProgBtn) {
                registerFromProgBtn.onclick = () => {
                    closeModal('programDetailModal');
                    if (applySelect) {
                        applySelect.value = data.title;
                    }
                    setTimeout(() => openModal('consultationModal'), 200);
                };
            }

            openModal('programDetailModal');
        } catch (err) {
            console.error('Error showing program modal:', err);
        }
    };

    // Facility Lightbox preview helper
    window.previewFacility = function (title, category, desc, imgSrc) {
        const titleEl = document.getElementById('facModalTitle');
        const catEl = document.getElementById('facModalCategory');
        const descEl = document.getElementById('facModalDesc');
        const imgEl = document.getElementById('facModalImg');

        if (titleEl) titleEl.textContent = title;
        if (catEl) catEl.textContent = category;
        if (descEl) descEl.textContent = desc;
        if (imgEl) {
            imgEl.src = imgSrc;
            imgEl.alt = title;
        }

        openModal('facilityModal');
    };
}

/* ==========================================================================
   7. LAZY LOADING FOR IMAGES (PERFORMANCE OPTIMIZATION)
   ========================================================================== */
function initLazyLoading() {
    const lazyImages = document.querySelectorAll('img.lazy-img');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const dataSrc = img.getAttribute('data-src');
                    if (dataSrc) {
                        img.src = dataSrc;
                        img.onload = () => img.classList.add('loaded');
                    }
                    obs.unobserve(img);
                }
            });
        });

        lazyImages.forEach((img) => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach((img) => {
            const dataSrc = img.getAttribute('data-src');
            if (dataSrc) img.src = dataSrc;
            img.classList.add('loaded');
        });
    }
}

/* ==========================================================================
   8. CONSULTATION FORM AJAX SUBMISSION
   ========================================================================== */
function initConsultationForm() {
    const forms = document.querySelectorAll('.consultation-form');

    forms.forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Kirim Pendaftaran';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sedang Memproses...
                `;
            }

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Close consultation modal if open
                    closeModal('consultationModal');

                    // Populate and open success celebration modal
                    const successModal = document.getElementById('successModal');
                    const successMessageEl = document.getElementById('successMessage');
                    const successWaBtn = document.getElementById('successWaBtn');

                    if (successMessageEl) {
                        successMessageEl.textContent = result.message || 'Pendaftaran Anda berhasil dicatat!';
                    }
                    if (successWaBtn && result.wa_url) {
                        successWaBtn.href = result.wa_url;
                    }

                    if (successModal) {
                        openModal('successModal');
                    } else {
                        alert(result.message);
                        if (result.wa_url) {
                            window.open(result.wa_url, '_blank');
                        }
                    }

                    form.reset();
                } else {
                    alert(result.message || 'Terjadi kesalahan. Silakan periksa kembali formulir Anda.');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('Gagal mengirim data. Silakan periksa koneksi internet Anda atau hubungi admin WhatsApp langsung.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        });
    });
}

/* ==========================================================================
   9. SCROLL TO TOP WITH RADIAL PROGRESS
   ========================================================================== */
function initScrollToTop() {
    const scrollBtn = document.getElementById('scrollToTopBtn');
    const progressPath = document.getElementById('scrollProgressPath');

    if (!scrollBtn) return;

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;

        if (scrollTop > 350) {
            scrollBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-6');
            scrollBtn.classList.add('opacity-100', 'translate-y-0');
        } else {
            scrollBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-6');
            scrollBtn.classList.remove('opacity-100', 'translate-y-0');
        }

        if (progressPath) {
            const pathLength = 307.876; // 2 * PI * 49
            const drawLength = (pathLength * scrollPercent) / 100;
            progressPath.style.strokeDashoffset = pathLength - drawLength;
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

/* ==========================================================================
   10. FAQ ACCORDION
   ========================================================================== */
function initFaqAccordion() {
    const faqButtons = document.querySelectorAll('.faq-toggle');

    faqButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const answer = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';

            // Close all other accordions
            faqButtons.forEach((otherBtn) => {
                if (otherBtn !== btn) {
                    otherBtn.setAttribute('aria-expanded', 'false');
                    const otherAnswer = otherBtn.nextElementSibling;
                    const otherIcon = otherBtn.querySelector('.faq-icon');
                    if (otherAnswer) {
                        otherAnswer.style.maxHeight = null;
                        otherAnswer.classList.add('hidden');
                    }
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                }
            });

            if (isExpanded) {
                btn.setAttribute('aria-expanded', 'false');
                if (answer) {
                    answer.style.maxHeight = null;
                    answer.classList.add('hidden');
                }
                if (icon) icon.style.transform = 'rotate(0deg)';
            } else {
                btn.setAttribute('aria-expanded', 'true');
                if (answer) {
                    answer.classList.remove('hidden');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });
}
