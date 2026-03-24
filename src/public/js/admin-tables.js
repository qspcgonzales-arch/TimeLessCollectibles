document.addEventListener('DOMContentLoaded', () => {
  const productsSearch = document.querySelector('[data-admin-products-search]');
  const productsSort = document.querySelector('[data-admin-products-sort]');
  const productsBody = document.querySelector('[data-admin-products-body]');
  const productsCount = document.querySelector('[data-admin-products-count]');

  if (productsSearch && productsSort && productsBody) {
    const rows = Array.from(productsBody.querySelectorAll('[data-admin-product-row]'));

    const renderProducts = () => {
      const search = productsSearch.value.trim().toLowerCase();
      const sortMode = productsSort.value;

      const visible = rows.filter((row) => {
        const haystack = `${row.dataset.name} ${row.dataset.category}`;
        const show = !search || haystack.includes(search);
        row.classList.toggle('d-none', !show);
        return show;
      });

      const sorted = [...visible].sort((a, b) => {
        const nameA = a.dataset.name;
        const nameB = b.dataset.name;
        const priceA = Number(a.dataset.price);
        const priceB = Number(b.dataset.price);

        switch (sortMode) {
          case 'name-asc':
            return nameA.localeCompare(nameB);
          case 'name-desc':
            return nameB.localeCompare(nameA);
          case 'price-asc':
            return priceA - priceB;
          case 'price-desc':
            return priceB - priceA;
          default:
            return 0;
        }
      });

      sorted.forEach((row) => productsBody.appendChild(row));

      if (productsCount) {
        productsCount.textContent = String(sorted.length);
      }
    };

    productsSearch.addEventListener('input', renderProducts);
    productsSort.addEventListener('change', renderProducts);
    renderProducts();
  }

  const ordersSearch = document.querySelector('[data-admin-orders-search]');
  const ordersStatus = document.querySelector('[data-admin-orders-status]');
  const ordersBody = document.querySelector('[data-admin-orders-body]');
  const ordersCount = document.querySelector('[data-admin-orders-count]');

  if (ordersSearch && ordersStatus && ordersBody) {
    const rows = Array.from(ordersBody.querySelectorAll('[data-admin-order-row]'));

    const renderOrders = () => {
      const search = ordersSearch.value.trim().toLowerCase();
      const statusFilter = ordersStatus.value;

      const visible = rows.filter((row) => {
        const statusMatch = statusFilter === 'all' || row.dataset.status === statusFilter;
        const text = `${row.dataset.email} ${row.dataset.product} ${row.dataset.location}`;
        const searchMatch = !search || text.includes(search);
        const show = statusMatch && searchMatch;
        row.classList.toggle('d-none', !show);
        return show;
      });

      if (ordersCount) {
        ordersCount.textContent = String(visible.length);
      }
    };

    ordersSearch.addEventListener('input', renderOrders);
    ordersStatus.addEventListener('change', renderOrders);
    renderOrders();
  }
});
