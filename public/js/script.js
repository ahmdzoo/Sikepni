document.addEventListener('DOMContentLoaded', () => {
  const search = document.querySelector('.input__group input');
  const table_rows = document.querySelectorAll('tbody tr');
  const table_headings = document.querySelectorAll('thead th');

  if (search) {
      // Add event listener for the search input
      search.addEventListener('input', searchTable);
  }

  function searchTable() {
      table_rows.forEach((row, i) => {
          let table_data = row.textContent.toLowerCase();
          let search_data = search.value.toLowerCase();

          // Toggle the 'hide' class based on search match
          row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
          row.style.setProperty('--delay', i / 25 + 's');
      });

      // Alternate row background color for visible rows
      document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
          visible_row.style.backgroundColor = (i % 2 === 0) ? 'transparent' : '#0000000b';
      });
  }

  // Sorting | Ordering data of HTML table
  table_headings.forEach((head, i) => {
      let sort_asc = true; // Toggle sort direction
      head.onclick = () => {
          // Reset active classes on headers
          table_headings.forEach(head => head.classList.remove('active', 'asc', 'desc'));
          head.classList.add('active', sort_asc ? 'asc' : 'desc');

          // Highlight the current sorted column cells
          document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
          table_rows.forEach(row => {
              row.querySelectorAll('td')[i].classList.add('active');
          });

          // Sort the table based on the clicked column
          sortTable(i, sort_asc);
          sort_asc = !sort_asc; // Toggle the sort direction
      };
  });

  function sortTable(column, sort_asc) {
      // Sorting table rows by the specified column
      const sortedRows = [...table_rows].sort((a, b) => {
          let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase();
          let second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

          if (first_row < second_row) return sort_asc ? -1 : 1;
          if (first_row > second_row) return sort_asc ? 1 : -1;
          return 0;
      });

      // Append sorted rows back to tbody
      const tbody = document.querySelector('tbody');
      sortedRows.forEach(row => tbody.appendChild(row));
  }
});

  /*=============== SHOW MENU ===============*/
const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
          nav = document.getElementById(navId)
 
    toggle.addEventListener('click', () =>{
        // Add show-menu class to nav menu
        nav.classList.toggle('show-menu');
 
        // Add show-icon to show and hide the menu icon
        toggle.classList.toggle('show-icon');
    });
 };
 
//  showMenu('nav-toggle','nav-menu')

