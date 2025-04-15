function showDetail(title) {
  const detailSection = document.getElementById('detail-view');
  const content = document.getElementById('detail-content');

  let details = '';

  switch (title) {
    case 'Supply Orders':
      details = 'Here you can view all supply orders including past and active ones.';
      break;
    case 'Delivery Status':
      details = 'Track delivery statuses by region and order ID.';
      break;
    case 'Route & Tracking':
      details = 'Live GPS tracking and route optimization for dispatched supplies.';
      break;
    case 'Order Details':
      details = 'Complete information about each order including sender/receiver.';
      break;
    case 'Update Supply':
      details = 'Update supply records by changing dispatched/delivered status.';
      break;
    default:
      details = 'No details available.';
  }

  content.innerHTML = `<h2>${title}</h2><p>${details}</p>`;
  detailSection.classList.remove('hidden');
}

function closeDetail() {
  document.getElementById('detail-view').classList.add('hidden');
}
