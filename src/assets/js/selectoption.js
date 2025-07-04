class SearchSelect {
    constructor(config) {
        this.config = {
            name: 'select',
            placeholder: 'Select an option',
            items: [],
            ...config
        };
        this.isOpen = false;
        this.selectedValue = '';
        this.filteredItems = [...this.config.items];
        this.init();
    }

    init() {
        this.createStructure();
        this.addEventListeners();
    }

    createStructure() {
        this.container = document.createElement('div');
        this.container.className = 'relative w-72';
        this.container.innerHTML = `
            <input type="hidden" name="${this.config.name}">
            <button type="button" class="${[
                'bg-gray-50 border border-gray-300',
                'text-gray-900 text-sm rounded-lg',
                'focus:ring-blue-500 focus:border-blue-500',
                'block w-full p-2.5 text-left',
                'dark:bg-gray-700 dark:border-gray-600',
                'dark:placeholder-gray-400 dark:text-white',
                'dark:focus:ring-blue-500 dark:focus:border-blue-500'
            ].join(' ')}">
                ${this.config.placeholder}
            </button>
            <div class="absolute hidden w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-700 dark:border-gray-600">
                <div class="p-2 border-b dark:border-gray-600">
                    <input type="text" placeholder="Search..." class="${[
                        'w-full px-3 py-2 text-sm',
                        'bg-gray-50 border border-gray-300 rounded-lg',
                        'focus:ring-blue-500 focus:border-blue-500',
                        'dark:bg-gray-700 dark:border-gray-600',
                        'dark:placeholder-gray-400 dark:text-white',
                        'dark:focus:ring-blue-500 dark:focus:border-blue-500'
                    ].join(' ')}">
                </div>
                <div class="overflow-y-auto max-h-48">
                    <ul class="py-1">
                        ${this.config.items.map(item => `
                            <li class="${[
                                'px-3 py-2 text-sm cursor-pointer',
                                'hover:bg-gray-100 dark:hover:bg-gray-600',
                                'dark:text-white'
                            ].join(' ')}" data-value="${item.value}">${item.label}</li>
                        `).join('')}
                    </ul>
                </div>
            </div>
        `;
        
        this.button = this.container.querySelector('button');
        this.dropdown = this.container.querySelector('div');
        this.searchInput = this.container.querySelector('input[type="text"]');
        this.hiddenInput = this.container.querySelector('input[type="hidden"]');
        this.itemsList = this.container.querySelector('ul');
    }

    addEventListeners() {
        this.button.addEventListener('click', () => this.toggleDropdown());
        this.searchInput.addEventListener('input', (e) => this.filterItems(e.target.value));
        document.addEventListener('click', (e) => this.handleOutsideClick(e));
        
        this.itemsList.querySelectorAll('li').forEach(item => {
            item.addEventListener('click', () => this.selectItem(item));
        });
    }

    toggleDropdown() {
        this.isOpen = !this.isOpen;
        this.dropdown.classList.toggle('hidden', !this.isOpen);
        if (this.isOpen) this.searchInput.focus();
    }

    filterItems(searchText) {
        const search = searchText.toLowerCase();
        this.filteredItems = this.config.items.filter(item => 
            item.label.toLowerCase().includes(search)
        );
        this.updateItemsList();
    }

    updateItemsList() {
        this.itemsList.innerHTML = this.filteredItems.map(item => `
            <li class="${[
                'px-3 py-2 text-sm cursor-pointer',
                'hover:bg-gray-100 dark:hover:bg-gray-600',
                'dark:text-white',
                this.selectedValue === item.value ? 'bg-blue-50 dark:bg-blue-900' : ''
            ].join(' ')}" 
                data-value="${item.value}">
                ${item.label}
            </li>
        `).join('');
        
        this.itemsList.querySelectorAll('li').forEach(item => {
            item.addEventListener('click', () => this.selectItem(item));
        });
    }

    selectItem(item) {
        const value = item.dataset.value;
        const label = item.textContent;
        this.selectedValue = value;
        this.button.textContent = label;
        this.hiddenInput.value = value;
        this.toggleDropdown();
        this.updateItemsList();
    }

    handleOutsideClick(e) {
        if (!this.container.contains(e.target)) {
            this.isOpen = false;
            this.dropdown.classList.add('hidden');
        }
    }
}