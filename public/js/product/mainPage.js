class MainPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            filter: {},
            products: {},
            productsCount: 0,
            requestLoadProduct: true,
            sorted: false
        };
    }

    componentDidMount() {
        $.ajax({
            url: window.location.href,
            type: "POST",
            success: (response) => {
                this.setState({
                    products: response.products,
                    productsCount: response.productsCount,
                    requestLoadProduct: false
                })
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    handleSorted(type) {
        $.ajax({
            url: '/product/sorted',
            type: "POST",
            data: {
                type: type,
                filter: this.state.filter.search
            },
            success: (response) => {
                this.setState({
                    products: response.products,
                    sorted: true
                })
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    handleTextChange(type, e) {
        let searchString = e.target.value;
        let filter = this.state.filter;

        if (this.changeText !== false || searchString.length < 3 || (filter.search
            && (e.target.value.length - 1 == filter['search'].length || e.target.value.length - 1 < filter['search'].length))
        ) {
            filter.search = searchString;

            this.setState({
                filter: filter
            });

            clearTimeout(this.changeText);
        }

        this.changeText = setTimeout(() => {
            if(searchString.length >= 3){
                this.handleSorted(type);
                this.changeText = false;
            }
        }, 500);
    }

    clearFilter() {
        $('#searchProduct').val('');

        this.state.filter = {};

        this.setState({
            filter: {}
        });
        location.reload(true);
    }

    sortedProducts() {
        return(
            <div className="title">Сортировка товара
                <div>
                    <div className="name">
                        <p className="option">По названию: <span className="clear" onClick={this.clearFilter.bind(this)}>очистить</span></p>
                        <input placeholder="Введите название продукта"
                               className="value" type="text" id="searchProduct"
                               onChange={this.handleTextChange.bind(this, 'product')}
                               onKeyPress={this.handleTextChange.bind(this, 'product')}
                        />
                    </div>
                    <div className="price">
                        <p className="option">По цене:</p>
                        <select className="sorting" onChange={this.handleTextChange.bind(this, 'price')}>
                            <option disabled={true}>--Выберите--</option>
                            <option value="asc">По возрастанию</option>
                            <option value="desc">По убыванию</option>
                        </select>
                    </div>
                    <div className="date">
                        <p className="option">По дате добавления:</p>
                        <select className="sorting" onChange={this.handleTextChange.bind(this, 'created_at')}>
                            <option value="desc">Вначале новые</option>
                            <option value="asc">Вначале старые</option>
                        </select>
                    </div>
                </div>
            </div>
        )
    }

    renderProduct() {
        const products = this.state.products;
        if(this.state.products.length === 0 && this.state.sorted === false){
            return(
            <div className="empty-page">
                <h3>В магазине пока нет никаких товаров.</h3>
            </div>
            )
        }
        return (
            <div className="container product-page">
                {this.sortedProducts()}
                <table className="table table-hover">
                    <thead>
                    </thead>
                    <tbody>
                    {this.state.products.map((item, index) =>
                        <tr key={index}>
                            <td><a href={"/product/" + item.product_id}>{item.title}</a></td>
                            <td>
                                <a href={"/product/" + item.product_id}>
                                    <img src={"/imagies/product/" + item.image} style={{width: "100px"}} />
                                </a>
                            </td>
                            <td>{item.price} бел. руб.</td>
                        </tr>
                        )}
                    </tbody>
                </table>
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