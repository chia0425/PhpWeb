<label for="date-picker">Select a Date:</label>
<input type="date" id="date-picker" />
<p id="display-date">Selected Date: </p>

<script>
  const dateInput = document.getElementById("date-picker");
  const displayDate = document.getElementById("display-date");

  // Reformat date when a selection is made
  dateInput.addEventListener("change", () => {
    const rawDate = dateInput.value; // Default format: YYYY-MM-DD
    if (rawDate) {
      const [year, month, day] = rawDate.split('-');
      const formattedDate = `${day}/${month}/${year}`; // Format as DD/MM/YYYY
      displayDate.textContent = `Selected Date: ${formattedDate}`;
    }
  });

  // Set default value as today's date
  const today = new Date();
  dateInput.value = today.toISOString().split('T')[0];
  const [defaultYear, defaultMonth, defaultDay] = dateInput.value.split('-');
  displayDate.textContent = `Selected Date: ${defaultDay}/${defaultMonth}/${defaultYear}`;
</script>