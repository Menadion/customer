document.addEventListener('DOMContentLoaded', () => {

    /* =========================
       CALENDAR
    ========================= */
    const calendarLabel = document.getElementById('calendarLabel');
    const calendarGrid = document.getElementById('calendarGrid');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    if (calendarLabel && calendarGrid && prevMonthBtn && nextMonthBtn) {
        let currentDate = new Date();

        function renderCalendar() {
            calendarGrid.innerHTML = '';

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            calendarLabel.textContent =
                currentDate.toLocaleString('default', {
                    month: 'long',
                    year: 'numeric'
                });

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                calendarGrid.appendChild(document.createElement('div'));
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayEl = document.createElement('div');
                dayEl.textContent = day;
                dayEl.classList.add('calendar-day');

                dayEl.addEventListener('click', () => {
                    calendarGrid
                        .querySelectorAll('.calendar-day')
                        .forEach(d => d.classList.remove('selected'));

                    dayEl.classList.add('selected');
                });

                calendarGrid.appendChild(dayEl);
            }
        }

        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    }

    /* =========================
       STEP NAVIGATION
    ========================= */
    const steps = [
        document.getElementById('step1'),
        document.getElementById('step2'),
        document.getElementById('step3')
    ];

    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle('d-none', i !== index);
        });

        backBtn.disabled = index === 0;
        nextBtn.textContent =
            index === steps.length - 1 ? 'Finish' : 'Next';
    }

    const confirmModalEl = document.getElementById('confirmModal');
    const confirmModal = confirmModalEl
        ? new bootstrap.Modal(confirmModalEl)
        : null;

    nextBtn.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        } else {
            confirmModal?.show();
        }
    });

    backBtn.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep);

    /* =========================
       SERVICES TOGGLE
    ========================= */
    document.querySelectorAll('.service-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });

    /* =========================
       EDIT INLINE (STEP 3)
    ========================= */
    document.querySelectorAll('.edit-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('.edit-row');
            const display = row.querySelector('.edit-display');
            const input = row.querySelector('.edit-input');

            const editing = row.classList.toggle('editing');

            if (editing) {
                display.classList.add('d-none');
                input.classList.remove('d-none');
                input.focus();
                btn.textContent = 'Done';
            } else {
                display.textContent = input.value || display.textContent;
                input.classList.add('d-none');
                display.classList.remove('d-none');
                btn.textContent = 'Edit';
            }
        });
    });

    /* =========================
       CONFIRM FINISH
    ========================= */
    document.getElementById('confirmYesBtn')?.addEventListener('click', () => {
        window.location.href = 'homepage.php';
    });

});
