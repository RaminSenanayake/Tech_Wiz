<div class="sidebarMain" id="sidebarMain">
    <div class="row row-gap-2 bg-body">
        <div class="col-12 border-bottom" style="height: 10vh;">
            <a href="adminDashboard.php" class="text-decoration-none comp_title fw-semibold" id="sidebarHeaderTitle" style="font-size: 45px;">Tech Wiz</a>
            <a href="javascript:void(0)" class="adminNavButton float-end" onclick="sidebarCollapse()"><i class="fa-solid fa-bars fa-2xl"></i></a>
        </div>
        <div class="col-12" style="height: 90vh;">
            <div class="row row-gap-2 row-cols-1 sidebar">
                <div class="col">
                    <a class="btn btn-outline-primary btn-lg sidebarItem manageUser" href="manageUsers.php" role="button">Manage Users</a>
                </div>
                <div class="col sidebarItemList">
                    <a class="btn btn-outline-primary btn-lg sidebarItem" href="javascript:void(0)" role="button" onclick="this.parentElement.classList.toggle('activeList')">Manage Products</a>
                    <div class="row">
                        <div class="col-12">
                            <a href="productListing.php" class="btn btn-outline-secondary mt-1 col-11">Product List</a>
                            <a href="addProduct.php" class="btn btn-outline-secondary col-11">Add Product</a>
                            <a href="updateProduct.php" class="btn btn-outline-secondary col-11">Update Product</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a class="btn btn-outline-primary btn-lg sidebarItem manageUser" href="manageOrders.php" role="button">Manage Orders</a>
                </div>
                <div class="col sidebarItemList">
                    <a class="btn btn-outline-primary btn-lg sidebarItem" href="javascript:void(0)" role="button" onclick="this.parentElement.classList.toggle('activeList')">Reports</a>
                    <div class="row">
                        <div class="col-12">
                            <a href="customerReport.php" class="btn btn-outline-secondary mt-1 col-11">Customer Report</a>
                            <a href="productReport.php" class="btn btn-outline-secondary col-11">Product Report</a>
                            <a href="orderReport.php" class="btn btn-outline-secondary col-11">Order Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>