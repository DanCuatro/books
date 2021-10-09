<template>
    <div>
        <div class="p-16 w-full grid grid-cols-7 gap-4 md:h-screen bg-gradient-to-r from-blue-400 to-blue-300">
            <div class="w-full md:col-span-2 col-span-7 bg-gradient-to-b from-blue-50 via-blue-50 to-blue-50 shadow-lg rounded-lg">
                <div class="text-center font-bold text-4xl md:mt-16 mt-4">
                    Form
                </div>
                <div class="m-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" >
                            Nombre Libro
                        </label>
                        <input v-model="name" class="bg-blue-50 border border-gray-500 rounded-xl shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  type="text" placeholder="Nombre Libro">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" >
                            Autor
                        </label>
                        <input v-model="author" class="bg-blue-50 border border-gray-500 rounded-xl shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  type="text" placeholder="Autor">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" >
                            Editorial
                        </label>
                        <input v-model="editorial" class="bg-blue-50 border border-gray-500 rounded-xl shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  type="text" placeholder="Editorial">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" >
                            Hojas
                        </label>
                        <input v-model="sheets" class="bg-blue-50 border border-gray-500 rounded-xl shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  type="number" placeholder="Hojas">
                    </div>
                    <div class="mb-4">
                        <button v-if="update == 0" @click="saveBooks()" class="bg-blue-500 hover:bg-blue-700 rounded-xl text-xl text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="button">
                            Añadir
                        </button>
                        <button v-if="update != 0" @click="updateBooks()" class="bg-blue-500 hover:bg-blue-700 rounded-xl text-xl text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="button">
                            Guardar
                        </button>
                        <button v-if="update != 0" @click="clearFields()" class="rounded-xltext-xl flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-lg py-1 px-2" type="button">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
            <div class="w-full md:col-span-5 col-span-7 p-6 bg-blue-50 h-full shadow-lg rounded-lg">
                <div class="text-center font-bold text-6xl">
                    Books
                </div>
                <div class="overflow-hidden overflow-x-auto">
                    <table class="table-auto w-full my-2">
                        <thead class="text-center bg-indigo-300 border-black border-b">
                            <tr class="text-black text-lg ">
                                <td width="18%">Libro</td>
                                <td width="18%">Autor</td>
                                <td width="18%">Editorial</td>
                                <td width="18%">Hojas</td>
                                <td>Accion</td>
                            </tr>
                        </thead>
                        <tbody >
                            <tr v-for="book in arrayBooks" :key="book.id" class="text-center">
                                <td v-text="book.name"      class="divide-x border-b border-black p-2"></td>
                                <td v-text="book.author" class="divide-x border-b border-black p-2"></td>
                                <td v-text="book.editorial"    class="divide-x border-b border-black p-2"></td>
                                <td v-text="book.sheets"    class="divide-x border-b border-black p-2"></td>
                                <td class="divide-x border-b border-black p-2 text-center">
                                    <button @click="loadFieldsUpdate(book)" class="bg-blue-500 hover:bg-blue-700 rounded-xl text-sm text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline" >Modificar</button>
                                    <button @click="deleteBook(book)"       class="bg-red-500 hover:bg-red-700 rounded-xl text-sm text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline" >Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <t-pagination @change="getBooksPage"
                        :total-items="totalRows"
                        :per-page="perPage"
                        :limit="limit"
                        :disabled="disabled"
                        v-model="currentPage"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                totalRows   : 1,
                perPage     : 1,
                limit       : 1,
                disabled    : 1,
                currentPage : 1,
                name        : "",
                editorial   : "",
                author      : "",
                sheets      : "",
                update      : 0,
                arrayBooks  : [],
            }
        },methods:{
             getBooksPage(page){
                let me  = this;
                let url = '/libros?page='+page
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    me.currentPage  = response.data.current_page;
                    me.totalRows    = response.data.total;
                    me.perPage      = response.data.per_page;
                    me.limit        = 5;
                    me.disabled     = false;
                    me.arrayBooks   = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },getBooks(){
                let me  = this;
                let url = '/libros'
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    me.currentPage  = response.data.current_page;
                    me.totalRows    = response.data.total;
                    me.perPage      = response.data.per_page;
                    me.limit        = 5;
                    me.disabled     = false;
                    me.arrayBooks   = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },saveBooks(){
                let me          = this;
                let url         = '/libros/guardar'
                let validation  = '';
                if(this.name=='')       validation += "- Es necesario que ingrese el nombre del libro\n";
                if(this.author=='')     validation += "- Es necesario que ingrese el Autor del libro\n";
                if(this.editorial=='')  validation += "- Es necesario que ingrese el Editorial del libro\n";
                if(this.sheets=='')     validation += "- Es necesario que ingrese el Numero de Hojas del libro\n";
                if(validation==''){
                    axios.post(url,{
                        'name'          : this.name,
                        'editorial'     : this.editorial,
                        'author'        : this.author,
                        'sheets'        : this.sheets,
                    }).then(function (response) {
                        me.getBooksPage(me.currentPage);
                        me.clearFields();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }else{
                    confirm(validation)
                }

            },updateBooks(){
                let me = this;
                axios.put('/libros/actualizar',{
                    'id'        : this.update,
                    'name'      : this.name,
                    'editorial' : this.editorial,
                    'author'    : this.author,
                    'sheets'    : this.sheets,
                }).then(function (response) {
                    me.getBooks();
                    me.clearFields();
                }).catch(function (error) {
                    console.log(error);
                });
            },loadFieldsUpdate(data){
                this.update = data.id
                let me      =this;
                let url     = '/libros/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                    me.name         = response.data.name;
                    me.editorial    = response.data.editorial;
                    me.author       = response.data.author;
                    me.sheets       = response.data.sheets;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },deleteBook(data){
                let me      = this;
                let book_id = data.id
                if (confirm('¿Seguro que deseas borrar este libro?')) {
                    axios.delete('/libros/borrar/'+book_id
                    ).then(function (response) {
                        me.getBooksPage(me.currentPage);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },clearFields(){
                this.name       = "";
                this.editorial  = "";
                this.author     = "";
                this.sheets     = "";
                this.update     = 0;
            }
        },mounted() {
            this.getBooks();
        }
    }
</script>
