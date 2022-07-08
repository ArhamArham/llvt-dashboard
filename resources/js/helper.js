import moment from 'moment';

export default {
    formatAmount: (amount) => {
        if (amount === null) {
            return 0;
        }
        return 'Rs. ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    formatDate: (date) => {
        return moment(date).format('Y/M/D')
    },
    calculateTotal: function (data, key) {
        let total = 0;
        for (let item of data) {
            total += parseInt(item[key]);
        }
        return this.formatAmount(total);
    }
}
