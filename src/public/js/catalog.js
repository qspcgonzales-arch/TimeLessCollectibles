document.addEventListener('DOMContentLoaded', () => {
  const root = document.querySelector('[data-catalog-root]');
  if (!root) {
    return;
  }

  const grid = root.querySelector('[data-catalog-grid]');
  const items = Array.from(root.querySelectorAll('[data-catalog-item]'));
  const chips = Array.from(root.querySelectorAll('[data-catalog-chips] .catalog-chip'));
  const searchInput = root.querySelector('[data-catalog-search]');
  const sortSelect = root.querySelector('[data-catalog-sort]');
  const countNode = root.querySelector('[data-catalog-count]');
  const emptyNode = root.querySelector('[data-catalog-empty]');
  const activeLabelNode = root.querySelector('[data-catalog-active-label]');
  const resetButton = root.querySelector('[data-catalog-reset]');
  const viewButtons = Array.from(root.querySelectorAll('.catalog-view-button'));

  const state = {
    category: root.dataset.initialCategory || '',
    search: (root.dataset.initialSearch || '').trim().toLowerCase(),
    sort: 'featured',
    view: 'grid',
  };

  const getChipLabel = (category) => {
    const chip = chips.find((node) => node.dataset.category === category);
    return chip ? chip.textContent.trim() : 'All categories';
  };

  const applyView = () => {
    grid.dataset.view = state.view;
    viewButtons.forEach((button) => {
      button.classList.toggle('is-active', button.dataset.view === state.view);
    });
  };

  const matchesFilters = (item) => {
    const categoryMatch = !state.category || item.dataset.category === state.category;
    const haystack = [item.dataset.name, item.dataset.categoryLabel, item.dataset.description].join(' ');
    const searchMatch = !state.search || haystack.includes(state.search);
    return categoryMatch && searchMatch;
  };

  const sortItems = (visibleItems) => {
    const sorted = [...visibleItems];
    sorted.sort((left, right) => {
      const nameLeft = left.dataset.name;
      const nameRight = right.dataset.name;
      const priceLeft = Number(left.dataset.price);
      const priceRight = Number(right.dataset.price);
      const indexLeft = Number(left.dataset.index);
      const indexRight = Number(right.dataset.index);

      switch (state.sort) {
        case 'name-asc':
          return nameLeft.localeCompare(nameRight);
        case 'name-desc':
          return nameRight.localeCompare(nameLeft);
        case 'price-asc':
          return priceLeft - priceRight;
        case 'price-desc':
          return priceRight - priceLeft;
        default:
          return indexLeft - indexRight;
      }
    });
    return sorted;
  };

  const render = () => {
    const visibleItems = items.filter(matchesFilters);
    const sortedItems = sortItems(visibleItems);

    items.forEach((item) => {
      item.classList.add('d-none');
    });

    sortedItems.forEach((item, index) => {
      item.classList.remove('d-none');
      item.style.setProperty('--catalog-delay', `${index * 35}ms`);
      grid.appendChild(item);
    });

    chips.forEach((chip) => {
      chip.classList.toggle('is-active', chip.dataset.category === state.category);
      if (!state.category && chip.dataset.category === '') {
        chip.classList.add('is-active');
      }
    });

    countNode.textContent = String(sortedItems.length);
    activeLabelNode.textContent = getChipLabel(state.category);
    emptyNode.classList.toggle('d-none', sortedItems.length > 0);
    applyView();
  };

  chips.forEach((chip) => {
    chip.addEventListener('click', () => {
      state.category = chip.dataset.category || '';
      render();
    });
  });

  searchInput.addEventListener('input', (event) => {
    state.search = event.target.value.trim().toLowerCase();
    render();
  });

  sortSelect.addEventListener('change', (event) => {
    state.sort = event.target.value;
    render();
  });

  viewButtons.forEach((button) => {
    button.addEventListener('click', () => {
      state.view = button.dataset.view;
      applyView();
    });
  });

  if (resetButton) {
    resetButton.addEventListener('click', () => {
      state.category = '';
      state.search = '';
      state.sort = 'featured';
      state.view = 'grid';
      searchInput.value = '';
      sortSelect.value = 'featured';
      render();
    });
  }

  if (searchInput && state.search) {
    searchInput.value = root.dataset.initialSearch || '';
  }

  render();
});
