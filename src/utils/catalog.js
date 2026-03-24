const CATEGORY_MAP = {
  '1': 'Plushies',
  '2': 'Action Figurines',
  '3': 'Card Collectibles',
  '4': 'CDs and Cartridges',
};

function getCategoryName(categoryId) {
  return CATEGORY_MAP[String(categoryId)] || 'Other';
}

function getStatusLabel(order) {
  if (order.delivered) {
    return 'Delivered';
  }

  if (order.delivering) {
    return 'Delivering';
  }

  return 'Pending';
}

function normalizeProduct(row) {
  let image = row.image;

  if (image && !image.startsWith('http') && !image.startsWith('/static/')) {
    image = image.startsWith('uploads/') ? `/static/uploads/${image.slice('uploads/'.length)}` : `/${image}`;
  }

  return {
    ...row,
    ID: row.ID || row.id,
    image,
    categoryName: getCategoryName(row.prodcategory),
  };
}

module.exports = {
  CATEGORY_MAP,
  getCategoryName,
  getStatusLabel,
  normalizeProduct,
};
