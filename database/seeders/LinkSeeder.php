<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::whereStatus(true)->create([
            'title' => 'Pedidos',
            'as' => 'Pedido',
            'to' => 'admin.orders.index',
            'icon' => 'fas fa-shopping-basket',
            'permission_title' => 'access_order',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Usuarios',
            'as' => 'Usuario',
            'to' => 'admin.users.index',
            'icon' => 'fas fa-users',
            'permission_title' => 'access_user',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Categorias',
            'as' => 'Categoria',
            'to' => 'admin.categories.index',
            'icon' => 'fas fa-bars',
            'permission_title' => 'access_category',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Produtos',
            'as' => 'Produto',
            'to' => 'admin.products.index',
            'icon' => 'fas fa-tshirt',
            'permission_title' => 'access_product',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Banners',
            'as' => 'Banner',
            'to' => 'admin.banner.index',
            'icon' => 'fas fa-tshirt',
            'permission_title' => 'access_banner',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Cupons',
            'as' => 'Cupom',
            'to' => 'admin.coupons.index',
            'icon' => 'fas fa-gift',
            'permission_title' => 'access_coupon',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Revisão de Produtos',
            'as' => 'Revisão',
            'to' => 'admin.reviews.index',
            'icon' => 'fas fa-comment',
            'permission_title' => 'access_review',
            'status' => 1,
        ]);

       

        Link::whereStatus(true)->create([
            'title' => 'Tags',
            'as' => 'Tag',
            'to' => 'admin.tags.index',
            'icon' => 'fas fa-tags',
            'permission_title' => 'access_tag',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Endereços de Usuários',
            'as' => 'Endereços',
            'to' => 'admin.user_addresses.index',
            'icon' => 'fas fa-address-book',
            'permission_title' => 'access_user_address',
            'status' => 1,
        ]);

     

        Link::whereStatus(true)->create([
            'title' => 'Métodos de Pagamentos',
            'as' => 'Pagamentos',
            'to' => 'admin.payment_methods.index',
            'icon' => 'fas fa-money-check-alt',
            'permission_title' => 'access_payment_method',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Contatos',
            'as' => 'contato',
            'to' => 'admin.contacts.index',
            'icon' => 'far fa-comment',
            'permission_title' => 'access_contact',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Páginas',
            'as' => 'Pagina',
            'to' => 'admin.pages.index',
            'icon' => 'far fa-file',
            'permission_title' => 'access_page',
            'status' => 1,
        ]);
        

    }
}
