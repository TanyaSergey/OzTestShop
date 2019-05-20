class Product extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            user: {},
            product: {},
            productInCart: false,
            requestLoadProduct: true,
        };
    }

    componentDidMount() {
        $.ajax({
            url: window.location.href,
            type: "POST",
            success: (response) => {
                this.setState({
                    user: response.user,
                    product: response.product,
                    productInCart: response.productInCart,
                    requestLoadProduct: false
                })
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    handleAddInCart() {
        this.setState({
            productInCart: true
        });
        $.ajax({
            url: '/cart/add',
            type: "POST",
            data: {
                selectProduct: this.state.product.product_id
            },
            success: (response) => {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    renderProduct() {
        const product = this.state.product;
        return (
            <div className="container product-page">
                <div className="row">
                    <div className="col-md-4 item-photo">
                        <img style={{maxWidth: "100%"}} src={"/imagies/product/" + product.image}/>
                    </div>
                    <div className="col-md-4">
                        <h3>{product.title}</h3>
                        <h3>Описание: <p style={{fontSize: "20px"}}>{product.description}</p></h3>
                        <h3>Цена:<span className="price">{product.price}</span> руб.</h3>
                        <div className="section" style={{paddingBottom: "20px"}}>
                            {this.state.productInCart ?
                                <a href="/cart">
                                    <div className="btn btn-success">
                                        <span style={{marginRight: "20px"}} className="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                        Перейти в корзину
                                    </div>
                                </a>
                                :
                                this.state.user !== null && this.state.product.user_id !== this.state.user.id ?
                                    <button className="btn btn-success" onClick={this.handleAddInCart.bind(this)} type="submit">
                                        <span style={{marginRight: "20px"}} className="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                        Добавить в корзину
                                    </button>
                                    : null
                            }
                        </div>
                    </div>
                    <div className="col-xs-9">
                        <div style={{width: "100%", borderTop: "1px solid silver"}}>
                            <p style={{padding: "15px"}}>
                                <small>
                                    {product.discription}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
        return this.state.requestLoadProduct ? this.renderLoader() : this.renderProduct();
    }
};



