function saveDateRange() {
  const startDate = document.getElementById('startDate').value;
  const endDate = document.getElementById('endDate').value;
  const search = document.getElementById('transactionId').value;

  const params = new URLSearchParams();
  if (startDate && endDate) {
    params.append('start_date', startDate);
    params.append('end_date', endDate);
  }
  if (search) {
    params.append('search', search);
  }

  window.location.href = window.location.pathname + '?' + params.toString();
}

function searchTransaction() {
  const search = document.getElementById('transactionId').value;
  const params = new URLSearchParams(window.location.search);
  params.set('search', search);
  window.location.href = window.location.pathname + '?' + params.toString();
}

function clearFilter() {
  window.location.href = window.location.pathname;
}

function cancelDateRange() {
  document.getElementById('tanggalDropdown').classList.remove('show');
}
