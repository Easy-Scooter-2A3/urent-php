const redirectKey = localStorage.getItem('redirect_to');
if (redirectKey != null) {
  localStorage.removeItem('redirect_to');
  window.location.href = redirectKey;
}
