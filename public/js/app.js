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
    initRemittanceCalculator();
    initModals();
    initLazyLoading();
    initConsultationForm();
    initScrollToTop();
    initFaqAccordion();
    initInstantPagePrefetch();
    initMobileBottomBar();
    initSocialProofTicker();
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

        if (window.isSakuraCanvasActive !== false) {
            requestAnimationFrame(animate);
        }
    }

    window.isSakuraCanvasActive = true;
    window.toggleSakuraCanvas = function () {
        window.isSakuraCanvasActive = !window.isSakuraCanvasActive;
        const btn = document.getElementById('sakuraToggleBtn');
        if (window.isSakuraCanvasActive) {
            if (btn) btn.innerHTML = '🌸 <span class="hidden sm:inline">Sakura:</span> <span class="text-emerald-600 font-bold">ON</span>';
            animate();
        } else {
            ctx.clearRect(0, 0, width, height);
            if (btn) btn.innerHTML = '🌸 <span class="hidden sm:inline">Sakura:</span> <span class="text-slate-400 font-bold">OFF</span>';
        }
    };

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

        // Format and display with smooth animated count-up ticker
        animateNumber(grossSalaryYenEl, grossSalary, '¥ ');
        grossSalaryIdrEl.textContent = `≈ Rp ${Math.round((grossSalary * JPY_TO_IDR) / 1000).toLocaleString('id-ID')}.000`;

        if (deductionsYenEl) deductionsYenEl.textContent = `- ¥ ${deductions.toLocaleString('id-ID')}`;
        if (livingCostYenEl) livingCostYenEl.textContent = `- ¥ ${livingCost.toLocaleString('id-ID')}`;

        animateNumber(netSavingsYenEl, netSavings, '¥ ');
        netSavingsIdrEl.textContent = `≈ Rp ${Math.round((netSavings * JPY_TO_IDR) / 1000).toLocaleString('id-ID')}.000 / bln`;
    }

    if (sectorSelect) sectorSelect.addEventListener('change', calculate);
    if (prefectureSelect) prefectureSelect.addEventListener('change', calculate);
    if (overtimeRange) overtimeRange.addEventListener('input', calculate);

    // Initial calculation
    calculate();
}

/* ==========================================================================
   5.5. INTERACTIVE REMITTANCE & NENKIN CLAIM CALCULATOR
   ========================================================================== */
function initRemittanceCalculator() {
    const remitAmountRange = document.getElementById('remitYenAmount');
    const remitDisplay = document.getElementById('remitYenDisplay');
    const remitProviderSelect = document.getElementById('remitProvider');
    const remitRateInput = document.getElementById('remitRate');
    const contractDurationRadios = document.querySelectorAll('input[name="contractDuration"]');

    const netMonthlyIdrEl = document.getElementById('remitNetMonthlyIdr');
    const calcTextEl = document.getElementById('remitNetMonthlyCalcText');
    const total1YearEl = document.getElementById('remitTotal1YearIdr');
    const totalContractEl = document.getElementById('remitTotalContractIdr');
    const contractYearsDisplay = document.getElementById('remitContractYearsDisplay');
    const nenkinEstimateEl = document.getElementById('remitNenkinEstimate');

    if (!remitAmountRange || !netMonthlyIdrEl) return;

    function calculateRemittance() {
        const sendYen = parseInt(remitAmountRange.value, 10) || 100000;
        const providerFee = parseInt(remitProviderSelect ? remitProviderSelect.value : 1000, 10) || 1000;
        const rate = parseFloat(remitRateInput ? remitRateInput.value : 106.5) || 106.5;

        let contractYears = 3;
        contractDurationRadios.forEach(r => {
            if (r.checked) contractYears = parseInt(r.value, 10) || 3;
        });

        // Update Slider Display
        if (remitDisplay) {
            remitDisplay.textContent = `¥ ${sendYen.toLocaleString('id-ID')} / bln`;
        }

        // Net Received = (sendYen - providerFee) * rate
        const netYen = Math.max(0, sendYen - providerFee);
        const netIdrMonthly = Math.round(netYen * rate);

        const total1YearIdr = netIdrMonthly * 12;
        const totalContractIdr = netIdrMonthly * (contractYears * 12);

        // Format outputs with smooth animated count-up ticker
        animateNumber(netMonthlyIdrEl, netIdrMonthly, 'Rp ');
        if (calcTextEl) {
            calcTextEl.textContent = `(¥ ${sendYen.toLocaleString('id-ID')} - ¥ ${providerFee.toLocaleString('id-ID')} biaya kirim) × Rp ${rate.toLocaleString('id-ID')}`;
        }

        animateNumber(total1YearEl, total1YearIdr, 'Rp ');
        animateNumber(totalContractEl, totalContractIdr, 'Rp ');
        if (contractYearsDisplay) {
            contractYearsDisplay.textContent = contractYears;
        }

        // Nenkin Estimation
        if (nenkinEstimateEl) {
            if (contractYears === 5) {
                const minNenkin = Math.round(750000 * rate);
                const maxNenkin = Math.round(950000 * rate);
                nenkinEstimateEl.textContent = `± Rp ${Math.round(minNenkin / 1000000)} Jt - Rp ${Math.round(maxNenkin / 1000000)} Juta`;
            } else {
                const minNenkin = Math.round(450000 * rate);
                const maxNenkin = Math.round(550000 * rate);
                nenkinEstimateEl.textContent = `± Rp ${Math.round(minNenkin / 1000000)} Jt - Rp ${Math.round(maxNenkin / 1000000)} Juta`;
            }
        }
    }

    remitAmountRange.addEventListener('input', calculateRemittance);
    if (remitProviderSelect) remitProviderSelect.addEventListener('change', calculateRemittance);
    if (remitRateInput) remitRateInput.addEventListener('input', calculateRemittance);
    contractDurationRadios.forEach(r => r.addEventListener('change', calculateRemittance));

    calculateRemittance();
}

/* ==========================================================================
   6. MODAL & POP-UP CONTROLLERS
   ========================================================================== */
window.openModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('active');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
};

window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('active');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
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

/* ==========================================================================
   11. PROGRAM MATCHMAKER QUIZ ENGINE
   ========================================================================== */
const quizAnswers = {
    age: '',
    education: '',
    japanese: '',
    sector: ''
};

window.selectQuizAnswer = function (key, value, nextStep) {
    quizAnswers[key] = value;

    // Update progress bar
    const bar = document.getElementById('quizProgressBar');
    const stepText = document.getElementById('quizStepText');
    const percentText = document.getElementById('quizPercentText');

    if (nextStep === 2) {
        document.getElementById('quizStep1')?.classList.add('hidden');
        document.getElementById('quizStep2')?.classList.remove('hidden');
        if (bar) bar.style.width = '50%';
        if (stepText) stepText.textContent = 'Langkah 2 dari 4: Pendidikan';
        if (percentText) percentText.textContent = '50%';
    } else if (nextStep === 3) {
        document.getElementById('quizStep2')?.classList.add('hidden');
        document.getElementById('quizStep3')?.classList.remove('hidden');
        if (bar) bar.style.width = '75%';
        if (stepText) stepText.textContent = 'Langkah 3 dari 4: Bahasa Jepang';
        if (percentText) percentText.textContent = '75%';
    } else if (nextStep === 4) {
        document.getElementById('quizStep3')?.classList.add('hidden');
        document.getElementById('quizStep4')?.classList.remove('hidden');
        if (bar) bar.style.width = '100%';
        if (stepText) stepText.textContent = 'Langkah 4 dari 4: Pilihan Sektor';
        if (percentText) percentText.textContent = '100%';
    } else if (nextStep === 'result') {
        document.getElementById('quizStep4')?.classList.add('hidden');
        document.getElementById('quizResultScreen')?.classList.remove('hidden');
        calculateQuizRecommendation();
    }
};

function calculateQuizRecommendation() {
    let recTitle = 'Tokutei Ginou (SSW) - Pengolahan Makanan';
    let recDesc = 'Berdasarkan profil usia dan pendidikan Anda, jalur Tokutei Ginou (SSW) adalah opsi terbaik dengan standar gaji resmi setara pekerja Jepang dan kesempatan tinggal jangka panjang.';
    let recSalary = '¥ 190.000 - 260.000';

    if (quizAnswers.education === 'Sarjana S1' && (quizAnswers.sector.includes('IT') || quizAnswers.sector.includes('Engineering'))) {
        recTitle = 'Engineer & Professional Career';
        recDesc = 'Latar belakang pendidikan Sarjana Anda sangat bernilai tinggi untuk jalur visa kerja Engineer di perusahaan teknologi dan manufaktur Jepang.';
        recSalary = '¥ 230.000 - 380.000+';
    } else if (quizAnswers.sector.includes('Kaigo')) {
        recTitle = 'Tokutei Ginou (SSW) - Kaigo (Caregiver)';
        recDesc = 'Bidang Kaigo (Perawat Lansia) memiliki kuota keberangkatan terbesar dan tunjangan tertinggi di Jepang dengan proses pelatihan intensif yang terstruktur.';
        recSalary = '¥ 210.000 - 270.000';
    } else if (quizAnswers.age === '18-25' && quizAnswers.japanese === 'Nol / Pemula') {
        recTitle = 'Ginou Jisshusei (Magang Kerja Industri)';
        recDesc = 'Program Magang Kerja Industri sangat ideal untuk pemula usia muda, memberikan pelatihan menyeluruh, tempat tinggal, dan tabungan pensiun (Nenkin) puluhan juta rupiah.';
        recSalary = '¥ 160.000 - 210.000';
    } else if (quizAnswers.sector.includes('Manufaktur')) {
        recTitle = 'Tokutei Ginou (SSW) - Manufaktur & Permesinan';
        recDesc = 'Industri manufaktur dan permesinan Jepang menawarkan jam lembur stabil, lingkungan kerja berteknologi canggih, dan fasilitas tunjangan lengkap.';
        recSalary = '¥ 195.000 - 260.000';
    }

    const titleEl = document.getElementById('quizResultProgramTitle');
    const descEl = document.getElementById('quizResultProgramDesc');
    const salaryEl = document.getElementById('quizResultSalary');

    if (titleEl) titleEl.textContent = recTitle;
    if (descEl) descEl.textContent = recDesc;
    if (salaryEl) salaryEl.textContent = recSalary;
}

window.claimQuizRecommendation = function () {
    const titleEl = document.getElementById('quizResultProgramTitle');
    const recTitle = titleEl ? titleEl.textContent.trim() : 'Tokutei Ginou (SSW)';
    
    closeModal('quizModal');

    // Preset values in consultation form
    const consultSelect = document.getElementById('consultProgramSelect');
    const consultAge = document.querySelector('#consultationModal input[name="age"]');
    const consultEdu = document.querySelector('#consultationModal select[name="education"]');
    
    if (consultSelect) consultSelect.value = recTitle;
    if (consultAge && quizAnswers.age === '18-25') consultAge.value = 21;
    if (consultAge && quizAnswers.age === '26-30') consultAge.value = 27;
    if (consultEdu && quizAnswers.education) consultEdu.value = quizAnswers.education;

    setTimeout(() => openModal('consultationModal'), 200);
};

window.prevQuizStep = function (targetStep) {
    const bar = document.getElementById('quizProgressBar');
    const stepText = document.getElementById('quizStepText');
    const percentText = document.getElementById('quizPercentText');

    document.querySelectorAll('.quiz-step').forEach((el) => el.classList.add('hidden'));

    if (targetStep === 1) {
        document.getElementById('quizStep1')?.classList.remove('hidden');
        if (bar) bar.style.width = '25%';
        if (stepText) stepText.textContent = 'Langkah 1 dari 4: Usia';
        if (percentText) percentText.textContent = '25%';
    } else if (targetStep === 2) {
        document.getElementById('quizStep2')?.classList.remove('hidden');
        if (bar) bar.style.width = '50%';
        if (stepText) stepText.textContent = 'Langkah 2 dari 4: Pendidikan';
        if (percentText) percentText.textContent = '50%';
    } else if (targetStep === 3) {
        document.getElementById('quizStep3')?.classList.remove('hidden');
        if (bar) bar.style.width = '75%';
        if (stepText) stepText.textContent = 'Langkah 3 dari 4: Bahasa Jepang';
        if (percentText) percentText.textContent = '75%';
    }
};

window.shareQuizToWA = function () {
    const titleEl = document.getElementById('quizResultProgramTitle');
    const recTitle = titleEl ? titleEl.textContent.trim() : 'Tokutei Ginou (SSW)';
    const age = quizAnswers.age || '18-25';
    const edu = quizAnswers.education || 'SMA/SMK';
    const jp = quizAnswers.japanese || 'Dasar';
    const sec = quizAnswers.sector || 'Umum';

    const msg = encodeURIComponent(`Halo Sensei LPK Sahabat Jepang Indonesia! Saya baru saja mengikuti Tes Kecocokan Karir Jepang di website dan mendapatkan rekomendasi program:\n\n★ *${recTitle}*\n- Rentang Usia: ${age}\n- Pendidikan: ${edu}\n- Kemampuan Bahasa: ${jp}\n- Sektor Diminati: ${sec}\n\nSaya ingin konsultasi langsung untuk persyaratan dan jadwal pendaftaran terdekat.`);
    window.open(`https://api.whatsapp.com/send?phone=6281234567890&text=${msg}`, '_blank');
};

window.resetQuiz = function () {
    quizAnswers.age = '';
    quizAnswers.education = '';
    quizAnswers.japanese = '';
    quizAnswers.sector = '';

    const bar = document.getElementById('quizProgressBar');
    const stepText = document.getElementById('quizStepText');
    const percentText = document.getElementById('quizPercentText');

    if (bar) bar.style.width = '25%';
    if (stepText) stepText.textContent = 'Langkah 1 dari 4: Usia';
    if (percentText) percentText.textContent = '25%';

    document.querySelectorAll('.quiz-step').forEach((el) => el.classList.add('hidden'));
    document.getElementById('quizResultScreen')?.classList.add('hidden');
    document.getElementById('quizStep1')?.classList.remove('hidden');
};

/* ==========================================================================
   10. INSTANT PAGE PREFETCHING (Zero-Lag Navigation)
   ========================================================================== */
function initInstantPagePrefetch() {
    const prefetched = new Set();

    document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]').forEach((link) => {
        link.addEventListener('mouseenter', () => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.includes('logout') || prefetched.has(href)) return;

            prefetched.add(href);
            const prefetchLink = document.createElement('link');
            prefetchLink.rel = 'prefetch';
            prefetchLink.href = href;
            document.head.appendChild(prefetchLink);
        }, { passive: true });
    });
}

/* ==========================================================================
   11. GLOBAL UI/UX UTILITIES: COPY-TO-CLIPBOARD & KEYBOARD SHORTCUTS
   ========================================================================== */
window.copyToClipboard = function (text, message = 'Tersalin ke clipboard!') {
    if (!text) return;
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => showCopyToast(message));
    } else {
        const temp = document.createElement('textarea');
        temp.value = text;
        temp.style.position = 'fixed';
        temp.style.left = '-9999px';
        document.body.appendChild(temp);
        temp.focus();
        temp.select();
        try {
            document.execCommand('copy');
            showCopyToast(message);
        } catch (err) {
            console.error('Copy fallback failed', err);
        }
        document.body.removeChild(temp);
    }
};

function showCopyToast(msg) {
    let toast = document.getElementById('globalCopyToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'globalCopyToast';
        toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-[9999] px-4 py-2.5 bg-slate-900/95 text-white text-xs font-bold rounded-2xl shadow-2xl border border-slate-700/80 flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-3';
        toast.innerHTML = `<span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span><span id="globalCopyToastMsg">${msg}</span>`;
        document.body.appendChild(toast);
    } else {
        const msgEl = document.getElementById('globalCopyToastMsg');
        if (msgEl) msgEl.textContent = msg;
    }

    requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', 'translate-y-3');
        toast.classList.add('opacity-100', 'translate-y-0');
    });

    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-3');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2400);
}

// Global Keyboard Shortcuts
document.addEventListener('keydown', (e) => {
    // Escape to close active modal
    if (e.key === 'Escape') {
        const activeModal = document.querySelector('.modal.active, [id$="Modal"].flex:not(.hidden)');
        if (activeModal && typeof window.closeModal === 'function') {
            window.closeModal(activeModal.id);
        }
    }

    // Slash key '/' to focus primary search input (when not typing in an input)
    if (e.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement?.tagName)) {
        const searchInput = document.querySelector('input[name="search"], input[name="keyword"], #studentSearchInput, #examSearchInput');
        if (searchInput) {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
    }
});

/* ==========================================================================
   12. NUMERIC COUNT-UP ANIMATION TICKER
   ========================================================================== */
function animateNumber(element, target, prefix = '', suffix = '') {
    if (!element) return;
    const start = parseInt(element.dataset.currentNum || '0', 10);
    element.dataset.currentNum = target;

    if (start === target || start === 0) {
        element.textContent = `${prefix}${target.toLocaleString('id-ID')}${suffix}`;
        return;
    }

    const duration = 200;
    const startTime = performance.now();

    function step(now) {
        const progress = Math.min((now - startTime) / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        const val = Math.round(start + (target - start) * ease);
        element.textContent = `${prefix}${val.toLocaleString('id-ID')}${suffix}`;
        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            element.textContent = `${prefix}${target.toLocaleString('id-ID')}${suffix}`;
        }
    }
    requestAnimationFrame(step);
}

/* ==========================================================================
   13. MOBILE STICKY BOTTOM QUICK ACTION BAR
   ========================================================================== */
function initMobileBottomBar() {
    const bar = document.getElementById('mobileBottomBar');
    if (!bar) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 320) {
            bar.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            bar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        } else {
            bar.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
            bar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        }
    }, { passive: true });
}

/* ==========================================================================
   14. LIVE SOCIAL PROOF ACTIVITY TICKER
   ========================================================================== */
function initSocialProofTicker() {
    if (window.location.pathname.startsWith('/admin') || window.location.pathname.includes('/kwitansi') || window.location.pathname.includes('/invoice')) {
        return;
    }

    const activities = [
        {
            icon: '🌸',
            title: 'CoE Resmi Terbit!',
            desc: 'Siswa Budi Santoso (Kaigo Tokyo) baru saja terbit Certificate of Eligibility.',
            time: '2m lalu'
        },
        {
            icon: '📥',
            title: 'Brosur 2026 Terunduh',
            desc: '1 Calon siswa asal Jawa Timur baru saja mengunduh Katalog Biaya Resmi.',
            time: '5m lalu'
        },
        {
            icon: '🎉',
            title: 'Lolos Wawancara Kaisha',
            desc: '3 Siswa lulusan Poltekkes lolos seleksi user rumah sakit lansia di Osaka.',
            time: '12m lalu'
        },
        {
            icon: '✈️',
            title: 'Terbang ke Narita',
            desc: 'Peserta Gelombang 4 SMILE Project sukses bertolak ke Jepang hari ini.',
            time: '24m lalu'
        },
        {
            icon: '📝',
            title: 'Tryout JLPT CBT Online',
            desc: 'Seorang siswa meraih nilai 96/100 (合格 - Lulus) simulasi JLPT N4.',
            time: '38m lalu'
        },
        {
            icon: '🤝',
            title: 'MoU Kampus Baru',
            desc: 'LPK SJI meresmikan kerjasama beasiswa Kaigo dengan Poltekkes Kemenkes.',
            time: '1j lalu'
        }
    ];

    let currentIndex = 0;
    let container = document.getElementById('socialProofToast');

    if (!container) {
        container = document.createElement('div');
        container.id = 'socialProofToast';
        container.className = 'fixed z-40 max-w-xs sm:max-w-sm pointer-events-auto transform transition-all duration-500 translate-y-24 opacity-0 scale-95';
        document.body.appendChild(container);
    }

    function showNextActivity() {
        const item = activities[currentIndex];
        currentIndex = (currentIndex + 1) % activities.length;

        container.innerHTML = `
            <div class="p-3 sm:p-3.5 rounded-2xl bg-white/95 text-slate-900 border border-red-200 shadow-2xl backdrop-blur-md flex items-start gap-3 relative overflow-hidden select-none">
                <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center text-base flex-shrink-0 mt-0.5 shadow-2xs">
                    ${item.icon}
                </div>
                <div class="flex-1 min-w-0 pr-4">
                    <div class="flex items-center justify-between gap-1">
                        <span class="text-[10px] font-black uppercase text-japan-700 tracking-wider font-mono">${item.title}</span>
                        <span class="text-[9px] text-slate-400 font-medium">${item.time}</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-snug mt-0.5 font-medium">${item.desc}</p>
                </div>
                <button type="button" onclick="dismissSocialProof()" class="text-slate-400 hover:text-slate-700 text-sm leading-none p-1 absolute top-2 right-2" aria-label="Tutup">
                    &times;
                </button>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-100">
                    <div class="h-full bg-japan-600 transition-all duration-[6000ms] ease-linear w-full" id="socialProofBar"></div>
                </div>
            </div>
        `;

        requestAnimationFrame(() => {
            container.classList.remove('translate-y-24', 'opacity-0', 'scale-95');
            container.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            const bar = document.getElementById('socialProofBar');
            if (bar) bar.style.width = '0%';
        });

        setTimeout(() => {
            container.classList.add('translate-y-24', 'opacity-0', 'scale-95');
            container.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
        }, 6000);
    }

    window.dismissSocialProof = function () {
        container.classList.add('translate-y-24', 'opacity-0', 'scale-95');
        container.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
    };

    setTimeout(showNextActivity, 7000);
    setInterval(showNextActivity, 28000);
}



