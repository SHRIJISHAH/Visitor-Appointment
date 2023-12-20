$(document).ready(function () {
    let selectedDate = null;
    const monthElement = document.getElementById("month");
    const yearElement = document.getElementById("year");
    const daysContainer = document.getElementById("days-container");
    const dateDataContainer = document.getElementById("date-data-container");

    function generateCalendar(month, year) {
        daysContainer.innerHTML = "";

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDayOfMonth = new Date(year, month, 1).getDay();

        monthElement.textContent = `${getMonthName(month)}`;
        yearElement.textContent = `${year}`;

        const startingDay = (firstDayOfMonth - 1 + 7) % 7;

        for (let i = 0; i < startingDay; i++) {
            const emptyDay = document.createElement("div");
            emptyDay.classList.add("empty");
            daysContainer.appendChild(emptyDay);
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement("div");
            day.classList.add("day");
            day.textContent = i;

            if (
                year === new Date().getFullYear() &&
                month === new Date().getMonth() &&
                i === new Date().getDate()
            ) {
                day.classList.add("current-date");
            }

            if (
                selectedDate &&
                year === selectedDate.getFullYear() &&
                month === selectedDate.getMonth() &&
                i === selectedDate.getDate()
            ) {
                day.classList.add("selected-date");
            }

            day.addEventListener("click", () => {
                const prevSelectedDate =
                    document.querySelector(".selected-date");
                if (prevSelectedDate) {
                    prevSelectedDate.classList.remove("selected-date");
                }

                day.classList.add("selected-date");
                selectedDate = new Date(year, month, i);
                updateNotesUI(selectedDate);
            });

            daysContainer.appendChild(day);
        }
        const currentDate = new Date();
        if (
            year === currentDate.getFullYear() &&
            month === currentDate.getMonth()
        ) {
            const currentDay = document.querySelector(
                `.day:nth-child(${currentDate.getDate() + startingDay})`
            );
            currentDay.classList.add("selected-date");
            selectedDate = currentDate;
            updateNotesUI(selectedDate);
        }
    }

    function getMonthName(monthIndex) {
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
        return months[monthIndex];
    }

    function updateNotesUI(selectedDate) {
        const formattedDate = `${selectedDate.getFullYear()}-${(
            selectedDate.getMonth() + 1
        )
            .toString()
            .padStart(2, "0")}-${selectedDate
            .getDate()
            .toString()
            .padStart(2, "0")}`;

        $.ajax({
            url: `/appointment/date/${formattedDate}`,
            type: "GET",
            success: function (appointments) {
                console.log(appointments);
                dateDataContainer.innerHTML = ``;
                if (appointments.length === 0) {
                    dateDataContainer.innerHTML +=
                        `<p class="no-appo">No appointments for this date.</p>`;
                } else {
                    dateDataContainer.innerHTML += "<ul>";
                    appointments.forEach((appointment) => {
                        dateDataContainer.innerHTML += `<div class="data-layout">
                        <li class="event_time">${appointment.start_time} - ${appointment.end_time}</li>
                        <p class="cat-name">${appointment.category} : ${appointment.event_name}</p>
                        <p class="event-description">${appointment.description}</p>`;
                    });
                    dateDataContainer.innerHTML += "</ul>";
                }
            },
            error: function (error) {
                console.error(error);
            },
        });
    }

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    generateCalendar(currentMonth, currentYear);

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    }

    function previousMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    }

    $("#next-btn").click(function () {
        nextMonth();
    });

    $("#prev-btn").click(function () {
        previousMonth();
    });

    $("#openAppointmentForm").click(function () {
        window.location.href = "/appointment";
    });
});
