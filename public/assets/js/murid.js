(function () {
  function initMuridPage() {
    const searchInput = document.getElementById('searchInput');
    const studentCards = document.querySelectorAll('.student-card');
    const loadMoreButton = document.getElementById('loadMore');
    const emptyState = document.getElementById('emptyState');

    if (!searchInput || !studentCards.length || !loadMoreButton || !emptyState) {
      return;
    }

    let showAll = false;

    function filterStudents() {
      const keyword = searchInput.value.toLowerCase().trim();
      let found = 0;

      studentCards.forEach(function (card, index) {
        const name = card.dataset.name;
        const studentClass = card.dataset.class;

        const matches =
          name.includes(keyword) ||
          studentClass.includes(keyword);

        const shouldShow =
          matches && (showAll || keyword !== '' || index < 8);

        card.hidden = !shouldShow;

        if (shouldShow) {
          found++;
        }
      });

      emptyState.style.display = found === 0 ? 'block' : 'none';

      loadMoreButton.hidden =
        keyword !== '' || studentCards.length <= 8;

      loadMoreButton.textContent = showAll
        ? 'Tampilkan lebih sedikit'
        : 'Tampilkan lebih banyak';
    }

    searchInput.addEventListener('input', filterStudents);

    loadMoreButton.addEventListener('click', function () {
      showAll = !showAll;
      filterStudents();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMuridPage, { once: true });
  } else {
    initMuridPage();
  }
})();
