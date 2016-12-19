class CreateSkus < ActiveRecord::Migration
  def change
    create_table :skus do |t|
      t.text :json

      t.timestamps null: false
    end
  end
end
