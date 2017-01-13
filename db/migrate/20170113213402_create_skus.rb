class CreateSkus < ActiveRecord::Migration
  def change
    create_table :skus do |t|
      t.string :brand
      t.string :model
      t.string :sku
      t.string :json

      t.timestamps null: false
    end
  end
end
