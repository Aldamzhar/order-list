<template>
    <div class="orders-container">
        <div class="mb-3">
            <label style="margin-bottom: 10px" for="statusFilter">Фильтровать по статусу заказа</label>
            <b-form-select id="statusFilter" v-model="selectVal.status" :options="statusOptions"></b-form-select>
        </div>
        <b-table
            striped
            hover
            :items="filteredOrders"
            :per-page="perPage"
            :current-page="currentPage"
            :fields="fields"
            v-model:sort-by="sortBy"
            v-model:sort-desc="sortDesc"
            responsive="sm"
        >
            <template #cell(name)="{ item }">
                {{ item.user.name }} {{ item.user.surname }} {{ item.user.patronymic }}
            </template>
            <template #cell(date)="{ item }">
                {{ formatDate(item.date) }}
            </template>
        </b-table>
        <b-pagination
            style="margin-top: 30px"
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
            align="fill"
            first-text="Первое"
            prev-text="Предыдущее"
            next-text="Следующее"
            last-text="Последнее"
        ></b-pagination>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            perPage: 5,
            currentPage: 1,
            sortBy: 'amount',
            sortDesc: false,
            selectedStatus: '',
            statusOptions: [],
            orders: [],
            fields: [
                { key: 'number', label: 'Номер заказа' },
                { key: 'date', label: 'Дата заказа' },
                { key: 'name', label: 'Полное имя клиента (ФИО)' },
                { key: 'amount', label: 'Сумма', sortable: true},
                { key: 'status', label: 'Статус заказа'},
            ],
            selectVal: {
                status: null
            }
        };
    },
    created() {
        this.fetchOrders();
    },
    computed: {
        filteredOrders() {
            return this.selectVal.status
                ? this.orders.filter(order => order.status === this.selectVal.status)
                : this.orders;
        },
        statusOptions() {
            let uniqueStatuses = Array.from(new Set(this.orders.map(order => order.status)));
            return [{ value: null, text: 'Все' }, ...uniqueStatuses.map(status => ({ value: status, text: status }))];
        },
        rows() {
            return this.orders.length
        }
    },
    methods: {
        fetchOrders() {
            axios.get('/api/orders')
                .then(response => {
                    this.orders = response.data.map(order => ({
                        ...order,
                        amount: parseFloat(order.amount)
                    }));
                    console.log(this.orders);
                    this.statusOptions = this.statusOptions;
                })
                .catch(error => {
                    console.error("There was an error fetching the orders: ", error);
                });
        },
        formatDate(value) {
            if (!value) return '';
            let date = new Date(value);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
            let year = date.getFullYear();
            let hours = String(date.getHours()).padStart(2, '0');
            let minutes = String(date.getMinutes()).padStart(2, '0');
            let seconds = String(date.getSeconds()).padStart(2, '0');
            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
        }
    }
};
</script>

<style scoped>
.orders-container {
    margin: 20px;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border: 1px solid #ccc;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>
