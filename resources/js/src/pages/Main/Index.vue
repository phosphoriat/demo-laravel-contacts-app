<template>
    <Layout>
        <div class="header-wrapper flex mb-4 px-4 md:px-0">
            <div class="header-title text-2xl font-bold">Контакты</div>

            <div class="cursor-pointer flex items-center text-blue-500 ml-auto" data-modal-target="modalAdd" data-modal-toggle="modalAdd" data-modal-placement="center-top">
                <svg class="w-[18px] h-[18px] text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </div>
        </div>

        <div class="main-wrapper flex flex-col bg-white rounded-xl shadow-sm p-8">
            <div class="main-body flex flex-col md:flex-row gap-x-8 mt-4">
                <div class="flex flex-col basis-full md:basis-1/2">
                    <div class="main-panel flex flex-col md:flex-row gap-x-10">
                        <div class="main-panel__search flex md:basis-1/2">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" placeholder="Поиск"
                                    class="bg-gray-200 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    v-model="q"
                                    @keyup="searchContact()">
                            </div>
                        </div>

                        <div class="main-panel__buttons hidden md:flex items-center md:basis-1/2">
                            <div class="main-panel__button flex">
                                <div class="cursor-pointer flex items-center text-blue-500" data-modal-target="modalAdd" data-modal-toggle="modalAdd">
                                    <svg class="w-[18px] h-[18px] text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                    <span class="pl-2">Добавить контакт</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body__contact-list-wrapper mt-10">
                        <div class="main-body__contact-list__item-group mb-2" v-for="group, key in contacts" :key="key">
                            <div class="main-body__contact-list__item-group__name bg-gray-200 pl-2">{{ key }}</div>
                            <div class="main-body__contact-list__item-group__list px-2">
                                <div class="main-body__contact-list__item-group__list-item w-full py-1 my-1 hover:text-blue-500 cursor-pointer"
                                    v-for="contact, index in group" :key="index"
                                    v-bind:class="index+1 < group.length ? 'border border-t-0 border-b-1 border-l-0 border-r-0 border-gray-300' : ''"
                                    v-bind:data-id="contact.id"
                                    v-bind:data-index="index"
                                >
                                    <span @click="getContact(contact.id)">{{ contact.surname }} {{ contact.name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col basis-full md:basis-1/2 md:mt-20">
                    <div class="main-body__contact-card flex flex-col border border-t-0 border-b-0 border-l-1 border-r-0 border-gray-300 pl-10  fixed md:relative w-full h-full md:h-auto top-0 left-0 bg-white pt-10 md:pt-0"
                        v-bind:class="detailContact.name ? '' : 'hidden'">
                        <div class="md:hidden flex items-center mb-6"
                            @click="resetForm(detailContact)">
                            <svg class="w-[16px] h-[16px] text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                            </svg>
                            <span class="text-blue-500 ml-2 text-lg">Контакты</span>
                        </div>
                        <div class="main-body__contact-title text-xl font-bold">Данные о контакте</div>

                        <div class="main-body__contact-card mt-5" v-bind:data-id="detailContact.id">
                            <div class="main-body__contact-card__name text-md mb-1"><span class="text-gray-500">Имя:</span> <span>{{ detailContact.name }}</span></div>
                            <div class="main-body__contact-card__surname text-md mb-1"><span class="text-gray-500">Фамилия:</span> <span>{{ detailContact.surname }}</span></div>
                            <div class="main-body__contact-card__phone text-md mb-1"><span class="text-gray-500">Номер телефона:</span> <span>{{ detailContact.phone }}</span></div>
                            <div class="main-body__contact-card__email text-md"><span class="text-gray-500">E-mail:</span> <span>{{ detailContact.email }}</span></div>
                        </div>

                        <div class="main-body__contact-card__buttons flex flex-col mt-5">
                            <div class="main-body__contact-card__buttons-edit text-md cursor-pointer text-blue-500 hover:underline mb-2"
                                data-modal-target="modalEdit"
                                data-modal-toggle="modalEdit"
                                @click="syncForm(detailContact, editForm)">Редактировать</div>
                            <div class="main-body__contact-card__buttons-delete text-md cursor-pointer text-rose-500 hover:underline"
                                data-modal-target="modalDelete"
                                data-modal-toggle="modalDelete">Удалить контакт</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>

    <div id="modalAdd" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-md font-semibold text-gray-900">Добавление контакта</h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" id="formAdd" @submit.prevent="addContact()">
                        <div>
                            <input type="text" name="name" id="name" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Имя" required
                            v-model="addForm.name">
                        </div>
                        <div>
                            <input type="text" name="surname" id="surname" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Фамилия" required
                            v-model="addForm.surname">
                        </div>
                        <div>
                            <input type="tel" name="phone" id="phone" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Номер телефона" required
                            v-maska data-maska="+7 (###) ###-##-##"
                            v-model="addForm.phone">
                        </div>
                        <div>
                            <input type="email" name="email" id="email" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="E-mail"
                            v-model="addForm.email">
                        </div>
                        
                        <div class="flex gap-x-5 mx-10 pt-4">
                            <button type="submit"
                                class="w-1/2 text-white bg-blue-500 hover:bg-blue-600 focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            >Сохранить</button>
                            <button type="button"
                                class="w-1/2 text-blue-500 hover:text-blue-600 focus:ring-0 focus:outline-none font-medium text-sm px-5 py-2.5 text-center"
                                data-modal-hide="modalAdd"
                            >Отменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modalEdit" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-md font-semibold text-gray-900">Редактирование контакта</h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" v-bind:data-id="detailContact.id" @submit.prevent="updateContact(detailContact.id)">
                        <div>
                            <input type="text" name="name" id="edit-name" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Имя" required
                                v-model="editForm.name">
                        </div>
                        <div>
                            <input type="text" name="surname" id="edit-surname" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Фамилия" required
                                v-model="editForm.surname">
                        </div>
                        <div>
                            <input type="tel" name="phone" id="edit-phone" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="Номер телефона" required
                                v-maska data-maska="+7 (###) ###-##-##"
                                v-model="editForm.phone">
                        </div>
                        <div class="relative">
                            <input type="email" name="email" id="edit-email" class="border-t-0 border-l-0 border-r-0 border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-blue-500 block w-full p-2.5" placeholder="E-mail"
                                v-model="editForm.email">

                            <div class="absolute right-2 bottom-3 cursor-pointer"
                                @click="resetInput('edit-email', editForm)">
                                <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex gap-x-5 mx-10 pt-4">
                            <button type="submit"
                                class="w-1/2 text-white bg-blue-500 hover:bg-blue-600 focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            >Сохранить</button>
                            <button type="button"
                                class="w-1/2 text-blue-500 hover:text-blue-600 focus:ring-0 focus:outline-none font-medium text-sm px-5 py-2.5 text-center"
                                data-modal-hide="modalEdit"
                            >Отменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modalDelete" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-md font-semibold text-gray-900">Подтвердите действие</h3>
                </div>

                <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-sm font-normal text-gray-500">Вы уверены, что хотите удалить контакт?</h3>
                </div>

                <div class="p-4 md:p-5 text-center" v-bind:data-id="detailContact.id">
                    <button type="button"
                        class="text-rose-500 focus:ring-0 focus:outline-none font-medium text-sm inline-flex items-center px-5 py-2.5 text-center me-2 hover:text-rose-600"
                        @click="deleteContact(detailContact.id)"
                    >Удалить</button>
                    <button type="button"
                        class="text-blue-500 focus:ring-0 focus:outline-none rounded-lg text-sm font-medium px-5 py-2.5 hover:text-blue-600 focus:z-10"
                        data-modal-hide="modalDelete"
                    >Отменить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import axios from 'axios';
import { vMaska } from "maska";
import Layout from '@/components/Layout.vue';

const props = defineProps({
    contacts: Object
});

const q = ref(null);
const detailContact = reactive({
    id: '',
    name: '',
    surname: '',
    phone: '',
    email: ''
});
const addForm = reactive({
    id: '',
    name: '',
    surname: '',
    phone: '',
    email: ''
});
const editForm = reactive({
    id: '',
    name: '',
    surname: '',
    phone: '',
    email: ''
});

function getContacts() {
    axios.get('/api/contact/filter')
        .then(response => {
            props.contacts = response.data.contacts;
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}

function getContact(id) {
    axios.get('/api/contact/'+id)
        .then(response => {
            for (const [key, value] of Object.entries(detailContact)) {
                detailContact[key] = response.data.contact[key];
            }
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}
function searchContact() {
    axios.get('/api/contact/filter?q='+q.value)
        .then(response => {
            props.contacts = response.data.contacts;
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}
function addContact() {
    axios.post('/api/contact/', addForm)
        .then(response => {
            getContacts();
            modalHide('modalAdd');
            resetForm(addForm);
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}
function updateContact(id) {
    axios.put('/api/contact/'+id, editForm)
        .then(response => {
            getContacts();
            getContact(id);
            modalHide('modalEdit');
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}
function deleteContact(id) {
    axios.delete('/api/contact/'+id)
        .then(response => {
            getContacts();
            resetForm(detailContact);
            modalHide('modalDelete');
        })
        .catch(function (error) {
            alert(error.response.data.message);
        });
}

function syncForm(formFrom, formTo) {
    for (const [key, value] of Object.entries(formFrom)) {
        formTo[key] = value;
    }
}
function resetForm(form) {
    for (const [key, value] of Object.entries(form)) {
        form[key] = '';
    }
}
function resetInput(selector, form) {
    document.getElementById(selector).value = '';
    form.email = '';
}
function modalHide(modalId) {
    const modal = FlowbiteInstances.getInstance('Modal', modalId);
    modal.hide();
}

onMounted(() => {
    initFlowbite();
    getContacts();
})
</script>

<style>
[modal-backdrop] {
    backdrop-filter: blur(1px);
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100%;
    top: 0;
}
</style>