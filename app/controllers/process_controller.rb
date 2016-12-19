class ProcessController < ApplicationController
    def submit
        sku = Sku.new
        jsonData = params
        jsonData['sku'] = generate_sku(19)
        sku.json = jsonData.to_json

        require 'aura-print'
        @output = AuraPrint.barcodeWeb(jsonData['sku'], 'Tech')
        @sku = jsonData['sku']
          sku.save!
    end

    def generate_sku(size = 6)
        charset = %w(2 3 4 6 7 9 A C D E F G H J K M N P Q R T V W X Y Z)
        (0...size).map { charset.to_a[rand(charset.size)] }.join
  end
end
