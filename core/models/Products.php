<?php 

class Products 
{
	/**
	 * Put all rows in to the table.
	 *
	 * @param array $array products movement array.
	 *
	 * @return void
	 */
	public function push_array ($array)
	{
		$date = new DateTime();
		$db = Connection:: prepare ( 
			"INSERT INTO products (product_name) VALUES (:product_name)
  		ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), product_name = product_name");

		$db2 = Connection:: prepare ( 
			"INSERT INTO warehouses (warehouse) VALUES (:warehouse)
  		ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), warehouse = warehouse");

		$db3 = Connection:: prepare ( "INSERT INTO product_warehouse (product_id,qty,warehouse_id,created_at) 
			VALUES (:product_id,:qty,:warehouse_id,:created_at);" );
		
		$db->bindParam(':product_name', $product_name);
		$db2->bindParam(':warehouse', $warehouse);
		$db3->bindParam(':product_id', $product_id);
		$db3->bindParam(':qty', $qty);
		$db3->bindParam(':warehouse_id', $warehouse_id);
		$db3->bindParam(':created_at', $time);

		foreach ($array as $row) {
			$product_name = $row[0];
			$qty = $row[1];
			$warehouse = $row[2];
			$time = $date->format('Y-m-d H:i:s');
			//Incert product.
			$db->execute();
			$product_id = Connection::lastInsertId();
			//Insert warehouse.
			$db2->execute();
			$warehouse_id = Connection::lastInsertId();
			//Insert product_warehouse
			$db3->execute();
		}

		$db -> closeCursor();
		
		return ;
	}

	/**
	 * Get all grouped products.
	 *
	 * @param array $array products movement array.
	 *
	 * @return array
	 */
	public function get_all ()
	{
		$sql = 	"SELECT 
								p_w.id AS id,
								p_w.product_id AS product_id,
								p_w.warehouse_id AS warehouse_id,
								SUM(qty) AS qty_sum,
								product_name ,
								warehouse 
						FROM product_warehouse p_w
						INNER JOIN products p ON p_w.product_id = p.id
						INNER JOIN warehouses w ON p_w.warehouse_id = w.id 
						GROUP BY product_name
						HAVING SUM(qty) > 0";

		$db = Connection:: prepare ($sql);
		$res = $db->execute();
		$products = $db -> fetchAll();

		foreach ($products as $key => $product) {
			$products[$key]['warehouse'] = $this->get_warehouses($product['product_id']);
		}

		$db -> closeCursor();
		return $products;
	}

	/**
	 * Get all warehouses for product by product id.
	 *
	 * @param int/string $product_id products movement array.
	 *
	 * @return array with warehouses.
 	 */
	public function get_warehouses ($product_id)
	{
		$sql = 	"SELECT 
								warehouse 
						FROM warehouses w
						INNER JOIN product_warehouse p_w ON p_w.warehouse_id = w.id
						WHERE p_w.product_id = :product_id
						GROUP BY warehouse
						HAVING SUM(qty) > 0";

		$db = Connection:: prepare ($sql);
		//Bind prosuct id.
		$product_id = $product_id;
		$db->bindParam(':product_id', $product_id);
		$db->execute();
		//Fetch object.
		$products = $db -> fetchAll();
		$db -> closeCursor();
		return $products;
	}
}