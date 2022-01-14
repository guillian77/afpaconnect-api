/**
 * Allow to create, fill and manage select HTMLElement more easily.
 *
 * @author Aufrère Guillian
 */
export class Select {
    #select;
    #selectedOption = null;
    #defaultOptionConfiguration = {
        'value': 'id',
        'text': 'name',
    };

    constructor(options = []) {
        this.#select = Select.#create();

        if (options.length > 0) {
            this.addOptions(options);
        }
    }

    /**
     * Create a select HTML Element.
     *
     * @return {HTMLSelectElement}
     */
    static #create()
    {
        return  document.createElement("select");
    }

    /**
     * Add class to select HTML Element.
     * @param {String} classes Class(es) to add.
     */
    addClass(classes)
    {
        this.#select.classList.add(classes)

        return this;
    }

    /**
     * Add options from array of data.
     *
     * @param {Array} options Array of data to construct options.
     * @param {Object} configuration Default keys used for option value and text content.
     *
     * @return this
     */
    addOptions(options, configuration = this.#defaultOptionConfiguration)
    {
        options.forEach(option => {
            this.#addOptionToSelect(option);
        });

        return this;
    }

    /**
     * Create and append option to #select.
     *
     * @param item
     */
    #addOptionToSelect(item)
    {
        // Create option HTML Element.
        let option = document.createElement("option");
            option.textContent = item.name;
            option.value = item.id;

        // Set selected option.
        if (this.#selectedOption && this.#selectedOption === item.value) {
            option.selected = true;
        }

        // Append this option to select.
        this.#select.append(option);
    }

    /**
     * Define the selected option inside the current #select.
     *
     * @param value
     *
     * @return {Select}
     */
    setSelected(value)
    {
        if (value === undefined) {
            return this;
        }

        this.#selectedOption = value;

        return this;
    }

    /**
     * Return the select HTML Element.
     *
     * @return {#select}
     */
    get()
    {
        return this.#select;
    }

    /**
     * Change current #select with a specific other.
     *
     * @param select
     *
     * @return {Select}
     */
    setTarget(select)
    {
        // Convert jQuery Element to pure HTMLElement.
        if (select instanceof jQuery){
            select = select[0];
        }

        this.#select = select;

        return this;
    }
}