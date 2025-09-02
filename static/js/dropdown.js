function toggleDropdown() {
  const dropdown = document.getElementById('customDropdown');
  dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' 
    ? 'block' 
    : 'none';
}

// Close dropdown if clicked outside
document.addEventListener('click', (event) => {
  const button = document.getElementById('dropdownTrigger');
  const dropdown = document.getElementById('customDropdown');

  if (!button.contains(event.target) && !dropdown.contains(event.target)) {
    dropdown.style.display = 'none';
  }
});
