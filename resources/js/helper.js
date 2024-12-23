export const years = Array.from({length: 100}, (_, i) => new Date().getFullYear() - i);

export const formatCurrency = (value) => {
    value.replace(/[^0-9]/g, '')


    // Remove tudo que não seja número
    value = value.toString().replace(/[^0-9]/g, "");

    // Converte para inteiro
    const intValue = parseInt(value, 10) || 0;

    // Formata para moeda brasileira
    const formatted = (intValue / 100).toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    return formatted;
};

export const handlePriceInput = (event, book) => {
    book.priceFormatted = null;

    const inputValue = event.target.value;

    const formattedValue = formatCurrency(inputValue);

    book.priceFormatted = "R$ " + formattedValue;

    book.price = parseFloat(formattedValue.replaceAll('.', '').replaceAll(',', '.'));
};
