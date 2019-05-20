class Cart extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            resultCart: {},
            products: {},
            requestLoadCart: true,
            isBuy: false
        };
    }

    componentDidMount() {
        $.ajax({
            url: window.location.href,
            type: "POST",
            success: (response) => {
                this.setState({
                    products: response.products,
                    requestLoadCart: false
                })
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    handleChangeQuantityProduct(id, type) {
        let products = this.state.products;
        const product = products.find(item => item.product_id === id);
        if (type === 'sub') {
            if (+product.quantityInCart === 1) {
                products = products.filter(item => id !== item.product_id);
            } else {
                product.quantityInCart -= 1;
            }
        } else if(+product.quantityInCart < product.quantity) {
            product.quantityInCart += 1;
        }
        this.setState({
            products: products
        });
    }

    handleBuyProducts() {
        $.ajax({
            url: 'order/buy',
            type: "POST",
            data: {
                products: this.state.products
            },
            success: (response) => {
                if (response.success === true) {
                    this.setState({
                        isBuy: true
                    })
                }
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }


    renderCart() {
        const cart = this.state.cart;
        if(this.state.products.length == 0 && this.state.isBuy == false){
            return <h1>Ваша корзина пуста</h1>
        } else if(this.state.isBuy == true) {
            return <h1>Ваша покупка совершена. Можете ее найти в <a style={{color: '#2579a9', cursor: 'point'}} href={'products/buy'}>Ваши покупки</a></h1>
        }
        return (
            <main role="main" className="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div className="row" style={{marginBottom: "50px"}}>
                    <div className="col-sm">
                        <h2>Ваша корзина</h2>
                    </div>
                </div>
                <div className="bd-example">
                    <table className="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Название продукта</th>
                            <th scope="col">Картинка</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Удалить</th>
                            <th scope="col">Контактные данные продавца</th>
                        </tr>
                        {this.state.products.map(item =>
                            <tr key={item.product_id}>
                                <td>{item.title}</td>
                                <td>
                                    {item.image ? <img src={"/imagies/product/" + item.image} width="100px"/> : null}
                                </td>
                                <td>{item.price}</td>
                                <td>
                                    <a onClick={this.handleChangeQuantityProduct.bind(this, item.product_id, 'sub')}>
                                        <input type="button" value="-" id="button_minus"/>
                                    </a>
                                    <span>{item.quantityInCart}</span>
                                    <a onClick={this.handleChangeQuantityProduct.bind(this, item.product_id, 'add')}>
                                        <input type="button" value="+" id="button_plus"/>
                                    </a>
                                </td>
                                <td><a href={"/cart/delete/" + item.product_id}>Удалить</a></td>
                                <td>
                                    <p>{item.user_data.first_name}</p>
                                    <p>{item.user_data.second_name}</p>
                                    <p>{item.user_data.email}</p>
                                    <p>{item.user_data.phone}</p>
                                </td>
                            </tr>
                        )}
                        </thead>
                    </table>
                </div>
                <button type="submit" className="btn btn-primary" onClick={this.handleBuyProducts.bind(this)}>купить</button>
            </main>
        )
    }

    renderLoader() {
        return (
            <div className="container product-page">
                <h1>Loading Product....</h1>
            </div>
        )
    }


    render() {
        return this.state.requestLoadCart ? this.renderLoader() : this.renderCart();
    }
};

