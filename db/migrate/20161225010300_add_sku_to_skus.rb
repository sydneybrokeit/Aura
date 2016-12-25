class AddSkuToSkus< ActiveRecord::Migration
  def change
      add_column :skus, :sku, :string
  end
end
