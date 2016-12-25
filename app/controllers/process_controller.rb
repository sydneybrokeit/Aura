class ProcessController < ApplicationController
    def submit
        sku = Sku.new
        jsonData = params
        jsonData.delete("commit")
        jsonData.delete("utf8")
        jsonData.delete("authenticity_token")
        jsonData.delete("action")
        jsonData.delete("controller")
        sku.sku = generate_sku(12)
        sku.json = jsonData.to_json

        require 'aura-print'
        #@output = AuraPrint.barcodeWeb(jsonData['sku'], 'Tech')
        @sku = sku.sku
          sku.save!
    end

    def generate_sku(size = 6)
        charset = %w(2 3 4 6 7 9 A C D E F G H J K M N P Q R T V W X Y Z)
        (0...size).map { charset.to_a[rand(charset.size)] }.join
  end
end
