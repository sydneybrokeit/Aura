class ProcessController < ApplicationController
  def submit
    sku = Sku.new
    sku.json = params
    sku.save
  end
end
